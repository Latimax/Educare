<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\Payment;
use App\Models\PromotionHistory;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();

        $staffId = Auth::guard('staff')->user()->id; // Assuming the user is logged in and has a staff ID

        // 1. Classes where staff is the class teacher
        $classes = ClassModel::where('class_teacher_id', $staffId)->get();

        $classIds = $classes->pluck('id');

        // 2. Total students in those classes
        $students = Student::whereIn('class_id', $classIds)->get();

        return view('staff.pages.students.index', compact('schoolinfo', 'students'));
    }

    public function showClasses($id = null)
    {

        $staffId = Auth::guard('staff')->user()->id; // Assuming the user is logged in and has a staff ID

        // 1. Classes where staff is the class teacher
        $classes = ClassModel::where('class_teacher_id', $staffId)->get();

        // If an ID is provided, filter classes by that ID
        if ($id) {
            $classes = ClassModel::where('class_teacher_id', $staffId)->where('level_id', $id)->orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();
        } else {
            // If no ID is provided, get all classes
            $classes = ClassModel::where('class_teacher_id', $staffId)->orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();
        }

        $schoolinfo = SchoolInfo::first();

        return view('staff.pages.students.classes', compact('schoolinfo', 'classes'));
    }

    public function students($id = null)
    {

        $schoolinfo = SchoolInfo::first();
        $students = $id ? Student::where("class_id", $id)->get() : Student::all();

        $className  = ClassModel::find($id)->class_name;

        return view('staff.pages.students.index', compact('schoolinfo', 'students', 'className'));
    }

    public function showLevels()
    {
        $schoolinfo = SchoolInfo::first();
        $levels = Level::orderBy('id', 'ASC')->orderBy('level_name', 'ASC')->get();

        return view('staff.pages.students.levels', compact('schoolinfo', 'levels'));
    }


    public function searchByName(Request $request)
    {


        $query = $request->input('q');

        $students = Student::query()
            ->select(
                "id",
                "firstname",
                "middlename",
                "lastname",
                "class_id",
            )
            ->where(function ($q) use ($query) {
                $q->where('firstname', 'like', "%{$query}%")
                    ->orWhere('middlename', 'like', "%{$query}%")
                    ->orWhere('lastname', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get();



        $fullnames = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'fullname' => trim("{$student->firstname} {$student->middlename} {$student->lastname} - {$student->studentClass->class_name}"),
            ];
        });

        // If no students found, return an empty array
        if ($fullnames->isEmpty()) {
            return response()->json([]);
        }


        // Return the students as a JSON response
        return response()->json($fullnames);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $schoolinfo = SchoolInfo::first();
        $classes = ClassModel::all();
        $parents = StudentParent::all();
        $promotion_history = PromotionHistory::where("student_id", $student->id)->get();
        $payments = Payment::where("student_id", $student->id)->get();


        return view('staff.pages.students.show', compact('schoolinfo', 'student', 'classes', 'parents', 'promotion_history', 'payments'));
    }
}
