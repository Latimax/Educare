<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Grade;
use App\Models\Level;
use App\Models\ResultComment;
use App\Models\SchoolInfo;
use App\Models\SessionModel;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\StudentScore;
use App\Models\Subject;
use Barryvdh\DomPDF\PDF as DomPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $levels =  Level::all();

        return view('admin.pages.computeresult.levels', compact('schoolinfo', 'levels'));
    }

    public function showClasses($id = null)
    {
        // If an ID is provided, filter classes by that ID
        if ($id) {
            $classes = ClassModel::where('level_id', $id)->orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();
        } else {
            // If no ID is provided, get all classes
            $classes = ClassModel::orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();
        }


        $schoolinfo = SchoolInfo::first();

        return view('admin.pages.computeresult.classes', compact('schoolinfo', 'classes'));
    }

    public function students($classId = null)
    {

        $schoolinfo = SchoolInfo::first();

        $studentResults = StudentResult::where('class_id', $classId)->get();

        $classId = $classId ?? 1; // Default to the first class if no ID is provided

        return view('admin.pages.computeresult.index', compact('schoolinfo', 'studentResults', 'classId'));
    }


    public function createNew($classId)
    {
        $schoolinfo = SchoolInfo::first();

        $class = ClassModel::find($classId);
        $subjects = Subject::where('level_id', $class->level_id)
            ->where("status", 'active')->get();


        $level_config = Level::where('id', $class->level_id)->first();

        // Fetch the class from the database
        $students = Student::where('class_id', $classId)
            ->whereDoesntHave('results')
            ->get();

        $comments = ResultComment::all()->load('grade');

        $grades = Grade::all();

        return view('admin.pages.computeresult.create', compact('schoolinfo', 'class', 'students', 'subjects', 'comments', 'grades', 'level_config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
            'term' => 'required|string|in:first,second,third',
            'session' => 'required|string|max:255',
            'total_time_present' => 'required|integer|min:0',
            'school_opened' => 'required|integer|min:0',
            'scores' => 'required|array',
            'scores.*.first_test' => 'nullable|numeric|min:0|max:20',
            'scores.*.second_test' => 'nullable|numeric|min:0|max:20',
            'scores.*.exam' => 'nullable|numeric|min:0|max:70',
            'scores.*.total' => 'nullable|numeric|min:0|max:100',
            'scores.*.grade' => 'nullable|string|max:10',
            'class_teacher_comment' => 'required',
            'principal_comment' => 'required',
            'conduct' => 'nullable|string|in:Distinction,Credit,Merit,Pass,Fail',
            'noofsubjectpass' => 'required|integer|min:0',
            'average' => 'required|numeric|min:0|max:100',
            'grade' => 'required|string|max:10',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare data for resultData JSON
        $resultData = [
            'scores' => [],
            'summary' => [
                'first_test_total' => 0,
                'second_test_total' => 0,
                'exam_total' => 0,
                'overall_total' => floatval($request->input('overall_total')),
                'grade' => $request->input('grade'),
            ],
        ];

        // Process scores
        foreach ($request->input('scores', []) as $subjectId => $score) {
            if (isset($score['offer']) && $score['offer']) {
                $resultData['scores'][$subjectId] = [
                    'subject_id' => $subjectId,
                    'first_test' => floatval($score['first_test'] ?? 0),
                    'second_test' => floatval($score['second_test'] ?? 0),
                    'exam' => floatval($score['exam'] ?? 0),
                    'total' => floatval($score['total'] ?? 0),
                    'grade' => $score['grade'] ?? '',
                ];
                $resultData['summary']['first_test_total'] += floatval($score['first_test'] ?? 0);
                $resultData['summary']['second_test_total'] += floatval($score['second_test'] ?? 0);
                $resultData['summary']['exam_total'] += floatval($score['exam'] ?? 0);
            }
        }

        // Create the student result record
        try {
            StudentResult::create([
                'student_id' => $request->input('student_id'),
                'class_id' => $request->input('class_id'),
                'session' => $request->input('session'),
                'term' => $request->input('term'),
                'resultData' => json_encode($resultData),
                'total_time_present' => $request->input('total_time_present'),
                'handwriting' => $request->input('handwriting.handwriting'),
                'verbal' => $request->input('verbal.verbal'),
                'sports' => $request->input('sports.sports'),
                'drawing' => $request->input('drawing.drawing'),
                'craftwork' => $request->input('craftwork.craftwork'),
                'punctuality' => $request->input('punctuality.punctuality'),
                'regularity' => $request->input('regularity.regularity'),
                'neatness' => $request->input('neatness.neatness'),
                'politeness' => $request->input('politeness.politeness'),
                'honesty' => $request->input('honesty.honesty'),
                'cooperation' => $request->input('cooperation.cooperation'),
                'emotional' => $request->input('emotional.emotional'),
                'health' => $request->input('health.health'),
                'behaviour' => $request->input('behaviour.behaviour'),
                'attentiveness' => $request->input('attentiveness.attentiveness'),
                'class_teacher_comment' => $request->input('class_teacher_comment'),
                'principal_comment' => $request->input('principal_comment'),
                'conduct' => $request->input('conduct'),
                'noofsubjectpass' => $request->input('noofsubjectpass'),
                'average' => floatval($request->input('average')),
                'position' => "",
            ]);

            return redirect()->route('admin.studentresults.filter', $request->input('class_id'))->with('success', 'Student result created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('success', 'Failed to create student result: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function getClasses($level_id)
    {
        $classes = ClassModel::where('level_id', $level_id)->get();
        return response()->json(['classes' =>  $classes]);
    }

    public function getScores($studentId)
    {

        $schoolinfo = SchoolInfo::first();
        $current_session = $schoolinfo->current_session;
        $current_term = $schoolinfo->current_term;

        $scores = StudentScore::where('student_id', $studentId)
            ->where('term', $current_term)
            ->where('session', $current_session)
            ->get();

        return response()->json([
            'success' => true,
            'scores' => $scores,
        ]);
    }


    public function rankAll($classId)
    {

        $schoolinfo = SchoolInfo::first();
        $current_session = $schoolinfo->current_session;
        $current_term = $schoolinfo->current_term;

        // //Dense Ranking

        // Fetch and decode average
        $studentResults = StudentResult::where('class_id', $classId)
            ->where('term', $current_term)
            ->where('session', $current_session)
            ->get()->sortByDesc('average', SORT_NUMERIC)->values(); // Reindex the collection

        $previous_average = null;
        $distinct_rank = 0; // Tracks distinct average positions

        foreach ($studentResults as $studentResult) {
            if ($studentResult->average !== $previous_average) {
                $distinct_rank++; // Increment for new unique average
            }

            $studentResult->position = $this->addOrdinalSuffix($distinct_rank);
            $studentResult->save();

            $previous_average = $studentResult->average;
        }

        return redirect()->back()->with('success', 'Student results ranked successfully.');

        //Standard ranking
        // // Fetch and sort results by average in descending order
        // $studentResults = StudentResult::where('class_id', $classId)
        //     ->where('term', $current_term)
        //     ->where('session', $current_session)
        //     ->get()->sortByDesc('average')->values();

        // $rank = 1;
        // foreach ($studentResults as $index => $studentResult) {
        //     // If this isn't the first student and their average is different from previous
        //     if ($index > 0 && $studentResult->average != $studentResults[$index - 1]->average) {
        //         $rank = $index + 1; // Set rank to current position
        //     }

        //     $studentResult->position = $this->addOrdinalSuffix($rank);
        //     $studentResult->save();
        // }

        // return redirect()->back()->with('success', 'Student results ranked successfully.');
    }

    // Helper function to add ordinal suffixes
    private function addOrdinalSuffix($number)
    {
        if (!in_array(($number % 100), [11, 12, 13])) {
            switch ($number % 10) {
                case 1:
                    return $number . 'st';
                case 2:
                    return $number . 'nd';
                case 3:
                    return $number . 'rd';
            }
        }
        return $number . 'th';
    }

    public function getSubjects($level_id)
    {
        $subjects = Subject::where('level_id', $level_id)->get();

        $currentSession = SchoolInfo::first()->current_session; // assuming this is a string like "2024/2025"
        $sessions = SessionModel::orderBy('session_name', 'ASC')->get();

        // Check if the current session is already in the list
        if (!$sessions->contains('session_name', $currentSession)) {
            $current = new SessionModel(['session_name' => $currentSession]);
            $sessions->prepend($current); // add to the beginning of the collection
        }
        return response()->json([
            'subjects' => $subjects,
            'sessions' => $sessions
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($resultId)
    {

        $schoolinfo = SchoolInfo::first();

        $result = StudentResult::find($resultId);

        $class = ClassModel::find($result->class_id);

        $level_config = Level::where('id', $class->level_id)->first();

        $subjects = Subject::where('level_id', $class->level_id)->where("status", 'active')->get();


        $comments = ResultComment::all()->load('grade');

        $grades = Grade::all();

        return view('admin.pages.computeresult.edit', compact('schoolinfo', 'class', 'comments', 'grades', 'subjects', 'result', 'level_config'));
    }

    public function print($resultId)
    {

        $schoolinfo = SchoolInfo::first();

        $result = StudentResult::find($resultId);

        $class = ClassModel::find($result->class_id);

        $level_config = Level::where('id', $class->level_id)->first();

        $subjects = Subject::where('level_id', $class->level_id)->where("status", 'active')->get();


        $comments = ResultComment::all()->load('grade');

        $grades = Grade::all();

        return view('admin.pages.computeresult.printpreview', compact('schoolinfo', 'class', 'comments', 'grades', 'subjects', 'result', 'level_config'));
    }

     public function printBsheet($classId)
    {

        $schoolinfo = SchoolInfo::first();

        $results = StudentResult::where('class_id', $classId)->get();

        $class = ClassModel::find($classId);

        $level_config = Level::where('id', $class->level_id)->first();

        $subjects = Subject::where('level_id', $class->level_id)->where("status", 'active')->get();

        $comments = ResultComment::all()->load('grade');

        $grades = Grade::all();

        return view('admin.pages.computeresult.printbroadsheetpreview', compact('schoolinfo', 'class', 'comments', 'grades', 'subjects', 'results', 'level_config'));
    }


    public function downloadPDF(DomPDF $pdf, $resultId)
    {

        $schoolinfo = SchoolInfo::first();

        $result = StudentResult::find($resultId);

        $class = ClassModel::find($result->class_id);

        $level_config = Level::where('id', $class->level_id)->first();

        $subjects = Subject::where('level_id', $class->level_id)->where("status", 'active')->get();


        $comments = ResultComment::all()->load('grade');

        $grades = Grade::all();


        // $pdf = $pdf->loadView('admin.pages.computeresult.printpreview', compact('schoolinfo', 'class', 'comments', 'grades', 'subjects', 'result', 'level_config'));

        // //return $pdf->download("result_{$result->id}.pdf");

        // //To display in browser instead of download:
        // return $pdf->stream("result_{$result->id}.pdf");

        return view('admin.pages.computeresult.pdfprint', compact('schoolinfo', 'class', 'comments', 'grades', 'subjects', 'result', 'level_config'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $result)
    {
        // Define validation rules
        $rules = [
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
            'term' => 'required|string|in:first,second,third',
            'session' => 'required|string|max:255',
            'total_time_present' => 'required|integer|min:0',
            'school_opened' => 'required|integer|min:0',
            'scores' => 'required|array',
            'scores.*.first_test' => 'nullable|numeric|min:0|max:20',
            'scores.*.second_test' => 'nullable|numeric|min:0|max:20',
            'scores.*.exam' => 'nullable|numeric|min:0|max:70',
            'scores.*.total' => 'nullable|numeric|min:0|max:100',
            'scores.*.grade' => 'nullable|string|max:10',
            'class_teacher_comment' => 'required|exists:result_comments,id',
            'principal_comment' => 'required|exists:result_comments,id',
            'conduct' => 'nullable|string|in:Distinction,Credit,Merit,Pass,Fail',
            'noofsubjectpass' => 'required|integer|min:0',
            'average' => 'required|numeric|min:0|max:100',
            'grade' => 'required|string|max:10'
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find the existing result
        $studentResult = StudentResult::findOrFail($result);

        // Prepare data for resultData JSON
        $resultData = [
            'scores' => [],
            'summary' => [
                'first_test_total' => 0,
                'second_test_total' => 0,
                'exam_total' => 0,
                'overall_total' => floatval($request->input('overall_total')),
                'average' => floatval($request->input('average')),
                'grade' => $request->input('grade'),
            ],
        ];

        // Process scores
        foreach ($request->input('scores', []) as $subjectId => $score) {
            if (isset($score['offer']) && $score['offer']) {
                $resultData['scores'][$subjectId] = [
                    'subject_id' => $subjectId,
                    'first_test' => floatval($score['first_test'] ?? 0),
                    'second_test' => floatval($score['second_test'] ?? 0),
                    'exam' => floatval($score['exam'] ?? 0),
                    'total' => floatval($score['total'] ?? 0),
                    'grade' => $score['grade'] ?? '',
                ];
                $resultData['summary']['first_test_total'] += floatval($score['first_test'] ?? 0);
                $resultData['summary']['second_test_total'] += floatval($score['second_test'] ?? 0);
                $resultData['summary']['exam_total'] += floatval($score['exam'] ?? 0);
            }
        }

        // Update the student result record
        try {
            $studentResult->update([
                'student_id' => $request->input('student_id'),
                'class_id' => $request->input('class_id'),
                'session' => $request->input('session'),
                'term' => $request->input('term'),
                'resultData' => json_encode($resultData),
                'total_time_present' => $request->input('total_time_present'),
                'handwriting' => $request->input('handwriting.handwriting'),
                'verbal' => $request->input('verbal.verbal'),
                'sports' => $request->input('sports.sports'),
                'drawing' => $request->input('drawing.drawing'),
                'craftwork' => $request->input('craftwork.craftwork'),
                'punctuality' => $request->input('punctuality.punctuality'),
                'regularity' => $request->input('regularity.regularity'),
                'neatness' => $request->input('neatness.neatness'),
                'politeness' => $request->input('politeness.politeness'),
                'honesty' => $request->input('honesty.honesty'),
                'cooperation' => $request->input('cooperation.cooperation'),
                'emotional' => $request->input('emotional.emotional'),
                'health' => $request->input('health.health'),
                'behaviour' => $request->input('behaviour.behaviour'),
                'attentiveness' => $request->input('attentiveness.attentiveness'),
                'class_teacher_comment' => $request->input('class_teacher_comment'),
                'principal_comment' => $request->input('principal_comment'),
                'conduct' => $request->input('conduct'),
                'noofsubjectpass' => $request->input('noofsubjectpass'),
                'average' => floatval($request->input('average')),
                'position' => "",
            ]);

            return redirect()->route('admin.studentresults.filter', $request->input('class_id'))
                ->with('success', 'Student result updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update student result: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($result)
    {
        // Find the student score by ID and delete it
        $result = StudentResult::find($result);
        $result->delete();
        return redirect()->back()->with('success', 'Student score deleted successfully.');
    }
}
