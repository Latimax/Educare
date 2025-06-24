<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\CbtQuestion;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CbtQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Level $level = null)
    {
        $schoolinfo = SchoolInfo::first();
        $staffId = Auth::guard('staff')->user()->id; // Get logged-in staff ID

        // Get class IDs for junior secondary
        $jss1_class_id = ClassModel::where('class_name', 'Junior Secondary 1')->value('id');
        $jss2_class_id = ClassModel::where('class_name', 'Junior Secondary 2')->value('id');
        $jss3_class_id = ClassModel::where('class_name', 'Junior Secondary 3')->value('id');

        // Junior secondary subjects taught by the staff
        $junior_subjects = Subject::where('staff_id', $staffId)
            ->whereHas('level', function ($query) {
                $query->where('level_name', 'LIKE', '%junior%');
            })
            ->withCount([
                'cbtQuestions as jss1_questions_count' => function ($query) use ($jss1_class_id) {
                    $query->where('classes_id', $jss1_class_id);
                },
                'cbtQuestions as jss2_questions_count' => function ($query) use ($jss2_class_id) {
                    $query->where('classes_id', $jss2_class_id);
                },
                'cbtQuestions as jss3_questions_count' => function ($query) use ($jss3_class_id) {
                    $query->where('classes_id', $jss3_class_id);
                }
            ])
            ->get();

        // Get class IDs for senior secondary
        $sss1_class_id = ClassModel::where('class_name', 'Senior Secondary 1')->value('id');
        $sss2_class_id = ClassModel::where('class_name', 'Senior Secondary 2')->value('id');
        $sss3_class_id = ClassModel::where('class_name', 'Senior Secondary 3')->value('id');

        // Senior secondary subjects taught by the staff
        $senior_subjects = Subject::where('staff_id', $staffId)
            ->whereHas('level', function ($query) {
                $query->where('level_name', 'LIKE', '%senior%');
            })
            ->withCount([
                'cbtQuestions as sss1_questions_count' => function ($query) use ($sss1_class_id) {
                    $query->where('classes_id', $sss1_class_id);
                },
                'cbtQuestions as sss2_questions_count' => function ($query) use ($sss2_class_id) {
                    $query->where('classes_id', $sss2_class_id);
                },
                'cbtQuestions as sss3_questions_count' => function ($query) use ($sss3_class_id) {
                    $query->where('classes_id', $sss3_class_id);
                }
            ])
            ->get();

        $levels = Level::all();
        $cbt_config = DB::table('cbt_configs')->first();

        return view('staff.pages.cbtquestions.index', compact(
            'schoolinfo',
            'junior_subjects',
            'senior_subjects',
            'levels',
            'cbt_config'
        ));
    }


    public function create($subjectId, $classId)
    {
        $schoolinfo = SchoolInfo::first();

        $subjectName = Subject::find($subjectId)->subject_name;
        $className = ClassModel::find($classId)->class_name ?? 'Unknown Class';


        return view('staff.pages.cbtquestions.create', compact('schoolinfo', 'subjectId', 'classId', 'subjectName', 'className'));
    }

    public function uploadImage(Request $request)
    {
        //Initialze array to hold uploaded image URLs
        if (!session()->has('image_paths')) {
            session(['image_paths' => []]);
        }

        if ($request->hasFile('file')) {

            $path = $request->file('file')->store('front/images/examuploads/', 'public');
            $url = Storage::url($path); // This is the line to check
            $url = str_replace('//', '/', $url);

            //Add the uploaded image URL to an array of image paths
            Session::push('image_paths', $url);

            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }

    public function view($subjectId, $className)
    {
        $schoolinfo = SchoolInfo::first();
        $staffId = Auth::guard('staff')->user()->id;

        // Find the class by name
        $class = ClassModel::where('class_name', $className)->first();
        if (!$class) {
            return response()->json(['error' => 'Class not found'], 404);
        }

        // Verify the subject belongs to the logged-in staff
        $subject = Subject::where('id', $subjectId)
            ->where('staff_id', $staffId)
            ->first();

        if (!$subject) {
            return abort(403, 'Unauthorized access to subject');
        }

        $subject_name = $subject->subject_name;
        $classId = $class->id;

        // Fetch the exam questions for this subject and class
        $questions = CbtQuestion::where('subject_id', $subjectId)
            ->where('classes_id', $classId)
            ->get();

        return view('staff.pages.cbtquestions.all', compact(
            'schoolinfo',
            'questions',
            'subject_name',
            'classId',
            'subjectId',
            'className'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'classes_id'   => 'required|exists:classes,id',
            'question'     => 'required|string',
            'option_a'     => 'required|string',
            'option_b'     => 'required|string',
            'option_c'     => 'required|string',
            'option_d'     => 'required|string',
            'answer'       => 'required|in:option_a,option_b,option_c,option_d',
            'description'  => 'nullable|string',
            'explanation'  => 'nullable|string',
        ]);

        $subjectId = $request->input('subject_id');
        $classId = $request->input('classes_id');

        // Handle image cleanup if needed (if you use images in options/question/description/explanation)
        $fieldsWithImages = [
            $request->input('question'),
            $request->input('option_a'),
            $request->input('option_b'),
            $request->input('option_c'),
            $request->input('option_d'),
            $request->input('description'),
            $request->input('explanation'),
        ];
        $paths = [];
        foreach ($fieldsWithImages as $content) {
            if ($content) {
                preg_match_all('/<img[^>]+src="([^"]+)"/i', $content, $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $path) {
                        if (strpos($path, 'front/') !== false) {
                            $cleanPath = '/' . substr($path, strpos($path, 'front/'));
                            $paths[] = $cleanPath;
                        }
                    }
                }
            }
        }

        if (session()->has('image_paths')) {
            $imagePaths = session('image_paths', []);
            foreach ($imagePaths as $path) {
                $path = str_replace('/storage', '', $path);
                if (in_array($path, $paths)) {
                    continue;
                }
                Storage::disk('public')->delete($path);
            }
            Session::forget('image_paths');
        }

        // Check if updating or creating
        $cbtQuestion = CbtQuestion::where('subject_id', $subjectId)
            ->where('classes_id', $classId)
            ->first();

        if ($cbtQuestion) {
            // Update
            $cbtQuestion->question = $request->input('question');
            $cbtQuestion->option_a = $request->input('option_a');
            $cbtQuestion->option_b = $request->input('option_b');
            $cbtQuestion->option_c = $request->input('option_c');
            $cbtQuestion->option_d = $request->input('option_d');
            $cbtQuestion->answer = $request->input('answer');
            $cbtQuestion->description = $request->input('description');
            $cbtQuestion->explanation = $request->input('explanation');
            $cbtQuestion->save();

            return redirect()->back()->with('success', 'CBT question updated successfully.');
        }

        return redirect()->back()->with('success', 'Error updating CBT question. Please try again.');
    }

    public function saveNew(Request $request)
    {
        $schoolinfo = SchoolInfo::first();


        // Validate the request data
        $validatedData = $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'classes_id'   => 'required|exists:classes,id',
            'question'     => 'required|string',
            'option_a'     => 'required|string',
            'option_b'     => 'required|string',
            'option_c'     => 'required|string',
            'option_d'     => 'required|string',
            'answer'       => 'required|in:option_a,option_b,option_c,option_d',
            'description'  => 'nullable|string',
            'explanation'  => 'nullable|string',
        ]);

        $subjectId = $request->input('subject_id');
        $classId = $request->input('classes_id');

        // Handle image cleanup if needed (if you use images in options/question/description/explanation)
        $fieldsWithImages = [
            $request->input('question'),
            $request->input('option_a'),
            $request->input('option_b'),
            $request->input('option_c'),
            $request->input('option_d'),
            $request->input('description'),
            $request->input('explanation'),
        ];
        $paths = [];
        foreach ($fieldsWithImages as $content) {
            if ($content) {
                preg_match_all('/<img[^>]+src="([^"]+)"/i', $content, $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $path) {
                        if (strpos($path, 'front/') !== false) {
                            $cleanPath = '/' . substr($path, strpos($path, 'front/'));
                            $paths[] = $cleanPath;
                        }
                    }
                }
            }
        }

        if (session()->has('image_paths')) {
            $imagePaths = session('image_paths', []);
            foreach ($imagePaths as $path) {
                $path = str_replace('/storage', '', $path);
                if (in_array($path, $paths)) {
                    continue;
                }
                Storage::disk('public')->delete($path);
            }
            Session::forget('image_paths');
        }

        CbtQuestion::create([
            'subject_id'   => $subjectId,
            'classes_id'   => $classId,
            'question'     => $request->input('question'),
            'option_a'     => $request->input('option_a'),
            'option_b'     => $request->input('option_b'),
            'option_c'     => $request->input('option_c'),
            'option_d'     => $request->input('option_d'),
            'answer'       => $request->input('answer'),
            'description'  => $request->input('description'),
            'explanation'  => $request->input('explanation'),
            'status'       => 'active', // Default status
        ]);
        $subject_name = Subject::find($subjectId)->subject_name;
        $className = ClassModel::find($classId)->class_name ?? 'Unknown Class';

        $questions = CbtQuestion::where('subject_id', $subjectId)
            ->where('classes_id', $classId)
            ->get();

        return view('staff.pages.cbtquestions.all', compact('schoolinfo', 'questions', 'subject_name', 'classId', 'subjectId', 'className'))->with('success', 'CBT question updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $schoolinfo = SchoolInfo::first();

        $question = CbtQuestion::find($id);

        $className = ClassModel::find($question->classes_id)->class_name ?? 'Unknown Class';

        return view('staff.pages.cbtquestions.subjects', compact('question', 'schoolinfo', 'className'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cbtQuestion = CbtQuestion::find($id);

        if (!$cbtQuestion) {
            return redirect()->back()->with('error', 'CBT question not found.');
        }

        // Delete the CBT question
        $cbtQuestion->delete();

        return redirect()->back()->with('success', 'CBT question deleted successfully.');
    }
}
