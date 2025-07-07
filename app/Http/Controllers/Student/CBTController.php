<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CbtAttempt;
use App\Models\CbtQuestion;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\StudentScore;
use App\Models\Subject;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CBTController extends Controller
{
    public function index()
    {
        $schoolinfo = SchoolInfo::first();

        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        // Get student's class
        $class = ClassModel::find($student->class_id);

        $level = Level::where('id', $class->level_id)->first();

        $subjects = Subject::where('level_id', $level->id)->get();

        $cbt_configs = DB::table('cbt_configs')->first();

        return view('student.pages.cbt.index', compact(
            'schoolinfo',
            'subjects',
            'cbt_configs'
        ));
    }

    public function instructions($type, $subjectId)
    {

        $schoolinfo = SchoolInfo::first();
        $student = Auth::guard('student')->user();
        $subject = Subject::findOrFail($subjectId);
        $cbt_configs = DB::table('cbt_configs')->first();

        // Count how many questions exist for this subject
        $total_questions_available = DB::table('cbt_questions')
            ->where('subject_id', $subjectId)
            ->where('status', 'active') // Only count active questions
            ->count();

        // Determine required number of questions based on type
        $required_questions = 0;
        if ($type == 'ft') {
            $required_questions = $cbt_configs->ft_total_questions;
        } elseif ($type == 'st') {
            $required_questions = $cbt_configs->st_total_questions;
        } elseif ($type == 'exam') {
            $required_questions = $cbt_configs->exam_total_questions;
        }

        // Check if available questions meet requirement
        $enable_exam = $total_questions_available >= $required_questions;

        return view('student.pages.cbt.instructions', compact(
            'schoolinfo',
            'subject',
            'cbt_configs',
            'type',
            'student',
            'enable_exam'  // Pass to Blade
        ));
    }

    public function startTest($type, $subjectId)
    {
        $student = Auth::guard('student')->user();
        $subject = Subject::findOrFail($subjectId);
        $cbt_configs = DB::table('cbt_configs')->first();

        if (Session::has('active_cbt_test')) {
            $activeTest = Session::get('active_cbt_test');
            $type = $activeTest['type'];
            $subjectId = $activeTest['subject_id'];
            $subject = Subject::findOrFail($subjectId);
        }

        // Validate test type
        if (!in_array($type, ['ft', 'st', 'exam'])) {
            Session::forget('active_cbt_test');
            return redirect()->route('student.cbt.index')->with('success', 'Invalid test type');
        }

        // Check if test is enabled
        $testStatus = $type == 'ft' ? $cbt_configs->ft_status : ($type == 'st' ? $cbt_configs->st_status : $cbt_configs->exam_status);
        if ($testStatus != '1') {
            Session::forget('active_cbt_test');
            return redirect()->route('student.cbt.index')->with('success', 'This test is not available');
        }

        // Get required number of questions
        $requiredQuestions = $type == 'ft' ? $cbt_configs->ft_total_questions : ($type == 'st' ? $cbt_configs->st_total_questions : $cbt_configs->exam_total_questions);

        // Check available questions
        $totalQuestionsAvailable = CbtQuestion::where('subject_id', $subjectId)
            ->where('status', 'active')
            ->count();

        if ($totalQuestionsAvailable < $requiredQuestions) {
            Session::forget('active_cbt_test');
            return redirect()->route('student.cbt.index')->with('success', 'Not enough questions available for this test');
        }

        // Check attempts
        $attemptsCount = CbtAttempt::where('student_id', $student->id)
            ->where('subject_id', $subjectId)
            ->where('test_type', $type)
            ->where('is_submitted', '1')
            ->count();

        if ($attemptsCount >= $cbt_configs->attempts_allowed) {
            Session::forget('active_cbt_test');

            $schoolinfo = SchoolInfo::first();
            $attempt = CbtAttempt::where('student_id', $student->id)
                ->where('subject_id', $subjectId)
                ->where('test_type', $type)
                ->first();

            $questions = json_decode($attempt->questions, true);
            $totalQuestions = count($questions);

            session()->flash('success', 'You have reached the maximum number of attempts');

            return view('student.pages.cbt.result', [
                'schoolinfo' => $schoolinfo,
                'type' => $type,
                'subjectId' => $subjectId,
                'correct' => $attempt->correct,
                'wrong' => $attempt->wrong,
                'score' => $attempt->score,
                'total_questions' => $totalQuestions,
            ]);
        }

        // Check for existing incomplete attempt
        $attempt = CbtAttempt::where('student_id', $student->id)
            ->where('subject_id', $subjectId)
            ->where('is_submitted', '0')
            ->first();

        if (!$attempt) {
            // Create new attempt
            $questions = CbtQuestion::where('subject_id', $subjectId)
                ->where('status', 'active')
                ->inRandomOrder()
                ->take($requiredQuestions)
                ->get(['id', 'question', 'option_a', 'option_b', 'option_c', 'option_d'])
                ->toArray();

            $questionsJson = array_map(function ($q) {
                return [
                    'id' => $q['id'],
                    'selected_option' => null
                ];
            }, $questions);

            $attempt = CbtAttempt::create([
                'student_id' => $student->id,
                'subject_id' => $subjectId,
                'class_id' => $student->class_id,
                'test_type' => $type,
                'questions' => json_encode($questionsJson),
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addMinutes($cbt_configs->total_time),
                'is_submitted' => false,
            ]);

            // Create session for active test
            Session::put('active_cbt_test', [
                'attempt_id' => $attempt->id,
                'type' => $type,
                'subject_id' => $subjectId,
                'end_time' => Carbon::parse($attempt->end_time)->toDateTimeString(),
            ]);
        } else {
            // Update session if attempt exists
            Session::put('active_cbt_test', [
                'attempt_id' => $attempt->id,
                'type' => $type,
                'subject_id' => $subjectId,
                'end_time' => Carbon::parse($attempt->end_time)->toDateTimeString(),
            ]);
        }

        // Calculate remaining time
        $remainingTime = Carbon::now()->diffInSeconds($attempt->end_time);

        // Load questions for the view
        $questionIds = array_column(json_decode($attempt->questions, true), 'id');
        $questions = CbtQuestion::whereIn('id', $questionIds)
            ->get(['id', 'question', 'option_a', 'option_b', 'option_c', 'option_d'])
            ->toArray();

        // Ensure questions maintain the same order as stored in attempt
        $orderedQuestions = [];
        foreach ($questionIds as $id) {
            $question = array_filter($questions, fn($q) => $q['id'] == $id);
            $orderedQuestions[] = reset($question);
        }

        return view('student.pages.cbt.cbt_test', [
            'schoolinfo' => SchoolInfo::first(),
            'subject' => $subject,
            'cbt_configs' => $cbt_configs,
            'type' => $type,
            'student' => $student,
            'questions' => $orderedQuestions,
            'attempt' => $attempt,
            'remainingTime' => $remainingTime,
        ]);

    }

    public function submit(Request $request)
    {
        $schoolinfo = SchoolInfo::first();

        $student = Auth::guard('student')->user();
        $attemptId = $request->input('attempt_id');

        // Validate the attempt
        $attempt = CbtAttempt::where('id', $attemptId)
            ->where('student_id', $student->id)
            ->where('is_submitted', '0')
            ->firstOrFail();

        $type = $attempt->test_type;
        $subjectId = $attempt->subject_id;

        // Decode questions
        $questions = json_decode($attempt->questions, true);
        $totalQuestions = count($questions);

        // Calculate correct and wrong answers
        $correct = 0;
        $wrong = 0;

        foreach ($questions as $question) {
            $cbtQuestion = CbtQuestion::find($question['id']);
            if (
                $cbtQuestion && $question['selected_option'] &&
                $cbtQuestion->answer === "option_" . strtolower($question['selected_option'])
            ) {
                $correct++;
            } else {
                $wrong++;
            }
        }

        // Calculate score (same logic as in submit)
        $score = $correct;
        if ($totalQuestions <= 10) {
            $score *= 2;
        }

        $studentClass = ClassModel::where('id', $student->class_id)->first();

        //Ensure the student doesnt score below minimum
        $min_score = Level::where('id', $studentClass->level_id)->first()->ft_min_score;

        if ($score < $min_score) {
            $score = $min_score;
        }

        // Update attempt
        $attempt->update([
            'is_submitted' => true,
            'score' => $score,
            'correct' => $correct,
            'wrong' => $wrong
        ]);

        if ($type === 'ft') {
            $updateData = ['first_test' => $score];
        } elseif ($type === 'st') {
            $updateData = ['second_test' => $score];
        } elseif ($type === 'exam') {
            $updateData = ['exam' => $score];
        }

        StudentScore::updateOrCreate(
            [
                'student_id' => $attempt->student_id,
                'subject_id' => $attempt->subject_id,
                'term'       => $schoolinfo->current_term,
                'session'    => $schoolinfo->current_session,
            ],
            $updateData
        );

        Session::forget('active_cbt_test');

        return view('student.pages.cbt.result', [
            'schoolinfo' => $schoolinfo,
            'type' => $type,
            'subjectId' => $subjectId,
            'correct' => $correct,
            'wrong' => $wrong,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'attempt' => $attempt
        ]);
    }
    public function updateOption(Request $request)
    {

        $student = Auth::guard('student')->user();

        // Validate request data
        $request->validate([
            'attempt_id' => 'required|exists:cbt_attempts,id',
            'question_id' => 'required|exists:cbt_questions,id',
            'selected_option' => 'required|in:A,B,C,D'
        ]);

        // Retrieve the attempt
        $attempt = CbtAttempt::where('id', $request->attempt_id)
            ->where('student_id', $student->id)
            ->where('is_submitted', false)
            ->firstOrFail();

        // Ensure the question belongs to the attempt
        $questions = json_decode($attempt->questions, true);
        $questionIndex = array_search($request->question_id, array_column($questions, 'id'));

        if ($questionIndex === false) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid question for this attempt'
            ], 422);
        }

        // Update the selected option
        $questions[$questionIndex]['selected_option'] = $request->selected_option;

        // Save updated questions JSON
        $attempt->update([
            'questions' => json_encode($questions)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Option updated successfully'
        ]);
    }
}
