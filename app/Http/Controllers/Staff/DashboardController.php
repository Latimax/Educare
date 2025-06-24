<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\Staff;
use App\Models\StudentParent;
use App\Models\Payment;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\SessionModel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $schoolinfo = SchoolInfo::first();

        $staffId = Auth::guard('staff')->user()->id; // Assuming the user is logged in and has a staff ID

        // 1. Classes where staff is the class teacher
        $classes = ClassModel::where('class_teacher_id', $staffId)->get();

        $classIds = $classes->pluck('id');

        // 2. Total students in those classes
        $totalStudents = Student::whereIn('class_id', $classIds)->count();

        // 3. Total classes the staff teaches
        $totalClasses = $classes->count();

        // 4. Total subjects assigned to this staff
        $totalSubjects = Subject::where('staff_id', $staffId)->count();

        // Active session
        $activeSession = SchoolInfo::first()->current_session;

        return view('staff.pages.dashboard', compact('schoolinfo', 'totalStudents', 'totalClasses', 'totalSubjects', 'activeSession'));
    }
}
