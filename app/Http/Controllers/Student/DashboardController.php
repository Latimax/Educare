<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\Payment;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        // Get student's class
        $class = ClassModel::find($student->class_id);

        $level = Level::where('id', $class->level_id)->first();

        // Subjects offered in the student's class
        $subjectCount = Subject::where('level_id', $level->id)->count();

        // Payment records for the student
        $payments = Payment::where('student_id', $studentId)
            ->orderBy('payment_date', 'desc')
            ->get();

        // Active session and term
        $activeSession = $schoolinfo->current_session ?? null;
        $activeTerm = $schoolinfo->current_term ?? null;

        return view('student.pages.dashboard', compact(
            'schoolinfo',
            'subjectCount',
            'payments',
            'activeSession',
            'activeTerm'
        ));
    }

    public function help()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        return view('student.pages.help.index', compact('schoolinfo'));
    }

    public function account()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        return view('student.pages.help.index', compact('schoolinfo'));
    }

    public function calculator()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        return view('student.pages.help.index', compact('schoolinfo'));
    }

    public function notes()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        return view('student.pages.help.index', compact('schoolinfo'));
    }

     public function notifications()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        return view('student.pages.help.index', compact('schoolinfo'));
    }

    public function calendar()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        return view('student.pages.help.index', compact('schoolinfo'));
    }
     public function documents()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        return view('student.pages.help.index', compact('schoolinfo'));
    }

     public function result()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        return view('student.pages.help.index', compact('schoolinfo'));
    }
}
