<?php

namespace App\Http\Controllers\Admin;

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

class DashboardController extends Controller
{
    public function index(){
        $schoolinfo = SchoolInfo::first();

        // Get system counts
        $totalStudents = Student::count();
        $totalStaff = Staff::count();
        $totalParents = StudentParent::count();
        $totalClasses = ClassModel::count();
        $totalLevels = Level::count();
        $totalSessions = SessionModel::count();
        $totalSubjects = Subject::count();

        // Payment statistics
        $totalPayments = Payment::count();
        $totalPaymentAmount = Payment::sum('amount_paid');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $completedPayments = Payment::where('status', 'paid')->count();

        // Recent activities
        $recentStudents = Student::latest()->take(5)->get();
        $recentPayments = Payment::with('student')->latest()->take(10)->get();

        // Monthly statistics
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $monthlyStudents = Student::whereMonth('created_at', $currentMonth)
                                 ->whereYear('created_at', $currentYear)
                                 ->count();
        $monthlyPayments = Payment::whereMonth('created_at', $currentMonth)
                                 ->whereYear('created_at', $currentYear)
                                 ->sum('amount_paid');

        // Active session
        $activeSession = SchoolInfo::first()->current_session;

        return view('admin.pages.dashboard', compact(
            'schoolinfo',
            'totalStudents',
            'totalStaff',
            'totalParents',
            'totalClasses',
            'totalLevels',
            'totalSessions',
            'totalSubjects',
            'totalPayments',
            'totalPaymentAmount',
            'pendingPayments',
            'completedPayments',
            'recentStudents',
            'recentPayments',
            'monthlyStudents',
            'monthlyPayments',
            'activeSession'
        ));
    }
}
