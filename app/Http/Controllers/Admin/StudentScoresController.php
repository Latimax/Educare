<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\SessionModel;
use App\Models\Student;
use App\Models\StudentScore;
use App\Models\Subject;
use Database\Seeders\SchoolSessions;
use Illuminate\Http\Request;

class StudentScoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $levels =  Level::all();

        return view('admin.pages.studentscores.index', compact('schoolinfo', 'levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     * Display the specified resource.
     */
    public function show(StudentScores $studentScores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentScores $studentScores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentScores $studentScores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentScores $studentScores)
    {
        //
    }
}
