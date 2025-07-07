<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class DocumentContoller extends Controller
{
    public function index()
    {
        $schoolinfo = SchoolInfo::first();

        // Logged-in student
        $student = Auth::guard('student')->user();
        $studentId = $student->id;

        // Get student's class
        $classId = $student->class_id;

        // Subjects offered in the student's class
        $subjectCount = Subject::where('class_id', $classId)->count();

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
}
