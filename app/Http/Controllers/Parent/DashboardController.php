<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Grade;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\Payment;
use App\Models\PromotionHistory;
use App\Models\ResultComment;
use App\Models\StudentResult;
use App\Models\Subject;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $parent = Auth::guard('parent')->user();

        // Get parent's children
        $children = Student::where('parent_id', $parent->id)->get();
        $totalChildren = $children->count();

        // Payment statistics for parent's children
        $childIds = $children->pluck('id');
        $totalPayments = Payment::whereIn('student_id', $childIds)->count();
        $totalPaymentAmount = Payment::whereIn('student_id', $childIds)->sum('amount_paid');
        $pendingPayments = Payment::whereIn('student_id', $childIds)->where('status', 'pending')->count();
        $completedPayments = Payment::whereIn('student_id', $childIds)->where('status', 'paid')->count();

        // Recent payments for parent's children
        $recentPayments = Payment::whereIn('student_id', $childIds)
            ->with('student')
            ->latest()
            ->take(10)
            ->get();

        // Monthly payment statistics
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $monthlyPayments = Payment::whereIn('student_id', $childIds)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount_paid');

        // Active session
        $activeSession = $schoolinfo->current_session;

        return view('parent.pages.dashboard', compact(
            'schoolinfo',
            'totalChildren',
            'totalPayments',
            'totalPaymentAmount',
            'pendingPayments',
            'completedPayments',
            'recentPayments',
            'monthlyPayments',
            'activeSession',
            'children'
        ));
    }

    public function showChildren()
    {
        $parent_id = Auth::guard('parent')->user()->id;

        $children = Student::where('parent_id', $parent_id)->orderBy('lastname', 'ASC')->get();

        $schoolinfo = SchoolInfo::first();

        return view('parent.pages.children.index', compact('schoolinfo', 'children'));
    }

    public function viewChild($id)
    {
        $parent_id = Auth::guard('parent')->user()->id;
        $child = Student::where('parent_id', $parent_id)->where('id', $id)->first();

        $schoolinfo = SchoolInfo::first();


        $classes = ClassModel::all();
        $promotion_history = PromotionHistory::where("student_id", $child->id)->get();

        $studentResults = StudentResult::where('student_id', $child->id)->get();


        return view('parent.pages.children.show', compact('schoolinfo', 'child', 'classes', 'studentResults', 'promotion_history'));
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

        return view('parent.pages.computeresult.printpreview', compact('schoolinfo', 'class', 'comments', 'grades', 'subjects', 'result', 'level_config'));
    }

    public function downloadPDF(Dompdf $pdf, $resultId)
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

        return view('parent.pages.computeresult.pdfprint', compact('schoolinfo', 'class', 'comments', 'grades', 'subjects', 'result', 'level_config'));
    }

    public function payments()
    {
        $schoolinfo = SchoolInfo::first();

        $parent_id = Auth::guard('parent')->user()->id;

        $student_id = Student::where('parent_id', $parent_id)->first()->id;

        $payments = Payment::with(['student'])->where('student_id', $student_id)->get();

        return view('parent.pages.payments.index', compact('schoolinfo', 'payments'));
    }

    public function printReceipt($payment)
    {
        $schoolinfo = SchoolInfo::first(); // Adjust based on your model
        $payment = Payment::find($payment);
        return view('parent.pages.payments.print_receipt', compact('payment', 'schoolinfo'));
    }
}
