<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\StudentScore;
use App\Models\Subject;
use Database\Seeders\SchoolSessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentScoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $staffId = Auth::guard('staff')->user()->id;

        // Get all level_ids from subjects taught by the staff
        $subjectLevelIds = Subject::where('staff_id', $staffId)
            ->pluck('level_id')
            ->unique();

        // Get classes either taught or class-teachered by the staff
        $classes = ClassModel::where('class_teacher_id', $staffId)
            ->orWhereIn('level_id', $subjectLevelIds)
            ->get()
            ->unique('id')     // Remove duplicates by class id
            ->values();        // Reset array keys

        return view('staff.pages.studentscores.index', compact('classes', 'schoolinfo'));
    }



    public function getClasses($level_id)
    {
        $classes = ClassModel::where('level_id', $level_id)->get();
        return response()->json(['classes' =>  $classes]);
    }

    public function getScores(Request $request)
    {
        $schoolinfo = SchoolInfo::first();
        $current_session = $schoolinfo->current_session;
        $current_term = $schoolinfo->current_term;

        $query = StudentScore::with(['student', 'subject'])
            ->where('session', $current_session)
            ->where('term', $current_term)
            ->where('subject_id', $request->subject_id);


        if ($request->class_id) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        $scores = $query->get()->map(function ($score) use ($request) {
            $score->term = $request->term;
            return $score;
        });

        return response()->json(['scores' => $scores]);
    }

    public function getSubjects($level, $classId)
    {
        $schoolinfo = SchoolInfo::first();
        $staffId = Auth::guard('staff')->user()->id;

        // Fetch the class and its name
        $class = ClassModel::with('level')->find($classId); // Assuming ClassModel has a 'level' relationship
        if (!$class) {
            return redirect()->back()->with('error', 'Class not found.');
        }

        $className = $class->class_name;
        $levelName = optional($class->level)->level_name ?? ''; // Safely get level name

        if ($level) {
            // If staff is class teacher and level is not Secondary
            if ($class->class_teacher_id == $staffId && !str_contains(strtolower($levelName), 'secondary')) {
                // Fetch all subjects for the level
                $subjects = Subject::where('level_id', $level)
                    ->orderBy('level_id', 'ASC')
                    ->orderBy('subject_name', 'ASC')
                    ->get();
            } else {
                // Fetch only subjects assigned to this staff
                $subjects = Subject::where('level_id', $level)
                    ->where('staff_id', $staffId)
                    ->orderBy('level_id', 'ASC')
                    ->orderBy('subject_name', 'ASC')
                    ->get();
            }

            if ($subjects->isEmpty()) {
                return redirect()->back()->with('success', 'No subjects available for this class level.');
            }

            return view('staff.pages.studentscores.subjects', compact('subjects', 'schoolinfo', 'classId', 'className'));
        } else {
            return $this->index(); // redirect to index properly
        }
    }

    public function studentScores($subjectId, $classId)
    {
        $schoolinfo = SchoolInfo::first();
        $subject = Subject::findOrFail($subjectId); // Get the subject
        $class = ClassModel::findOrFail($classId);   // Get the class

        $session = SchoolInfo::first()->current_session;
        $term = SchoolInfo::first()->current_term;

        // Get students in this class
        $students = Student::where('class_id', $classId)->get();

        // Fetch scores for all students in this class for the given subject
        $scores = StudentScore::where('subject_id', $subjectId)
            ->where('session', $session)
            ->where('term', $term)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id'); // So we can access by student_id easily

        $level_config = Level::where('id', $class->level_id)->first();

        return view('staff.pages.studentscores.show-scores', compact(
            'schoolinfo',
            'students',
            'subject',
            'class',
            'scores',
            'session',
            'term',
            'level_config'
        ));
    }

    public function studentScoresUpdate(Request $request)
    {

         // Find class and level configuration
        $class = ClassModel::find($request->class_id);
        if (!$class) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found'
            ], 404);
        }

        $level_config = Level::find($class->level_id);
        if (!$level_config) {
            return response()->json([
                'status' => 'error',
                'message' => 'Level configuration not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'student_id'   => 'required|exists:students,id',
            'subject_id'   => 'required|exists:subjects,id',
            'class_id'     => 'required|exists:classes,id',
            'term'         => 'required|string',
            'session'      => 'required|string',
            'first_test'   => 'nullable|numeric|min:' . $level_config->ft_min_score . '|max:' . $level_config->ft_max_score,
            'second_test'  => 'nullable|numeric|min:' . $level_config->st_min_score . '|max:' . $level_config->st_max_score,
            'exam'         => 'nullable|numeric|min:' . $level_config->exam_min_score . '|max:' . $level_config->exam_max_score
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Safely calculate total exam score
        $examScore = floatval($request->exam ?? 0) + floatval($request->exam_inc ?? 0);

        if ($examScore > 100) {
            return response()->json([
                'status' => 'error',
                'message' => 'Total exam score (exam + exam_inc) cannot exceed 100'
            ], 422);
        }

        // Create or update the student score
        StudentScore::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'term'       => $request->term,
                'session'    => $request->session,
            ],
            [
                'first_test'  => $request->first_test,
                'second_test' => $request->second_test,
                'exam'        => $examScore,
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Scores updated successfully'
        ], 200);
    }
}
