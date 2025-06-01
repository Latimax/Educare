<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $students = Student::all();

        return view('admin.pages.students.index', compact('schoolinfo', 'students'));
    }

    public function showClasses($id = null)
    {
        // If an ID is provided, filter classes by that ID
        if ($id) {
            $classes = ClassModel::where('level_id', $id)->orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();
        } else {
            // If no ID is provided, get all classes
            $classes = ClassModel::orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();
        }

        $schoolinfo = SchoolInfo::first();

        return view('admin.pages.students.classes', compact('schoolinfo', 'classes'));
    }

    public function showChildren($id = null)
    {
        // If an ID is provided, filter children by that parent ID
        if ($id) {
            $children = Student::where('parent_id', $id)->orderBy('lastname', 'ASC')->get();
            if ($children->isEmpty()) {
                return redirect()->back()->with('success', 'No children found for this parent.');
            }
        } else {
            return redirect()->route('admin.students.index')->with('success', 'No parent ID provided.');
        }

        $schoolinfo = SchoolInfo::first();
        $students = $children;

        return view('admin.pages.students.index', compact('schoolinfo', 'students'));
    }
    public function showLevels()
    {
        $schoolinfo = SchoolInfo::first();
        $levels = Level::orderBy('id', 'ASC')->orderBy('level_name', 'ASC')->get();

        return view('admin.pages.students.levels', compact('schoolinfo', 'levels'));
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
    public function create()
    {
        $schoolinfo = SchoolInfo::first();
        $classes = ClassModel::orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();
        $parents = StudentParent::all();

        //Generate a unique admission number 11 digit
        $last_student = Student::orderBy('id', 'desc')->first();
        // If there are no student records, start with 00000000001
        if ($last_student) {
            $last_studentId = $last_student->id;
            $admission_number = str_pad($last_studentId, 11, '0', STR_PAD_LEFT);
        } else {
            $admission_number = '00000000001';
        }

        return view('admin.pages.students.create', compact('schoolinfo', 'classes', 'parents', 'admission_number'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'firstname'         => 'required|string|max:255',
            'middlename'        => 'nullable|string|max:255',
            'lastname'          => 'required|string|max:255',
            'dob'               => 'required|date',
            'address'           => 'required|string|max:500',
            'state'             => 'required|string|max:100',
            'country'           => 'required|string|max:100',
            'class_id'          => 'required|exists:classes,id',
            'parent_id'         => 'nullable|exists:parents,id',
            'gender'            => 'required|in:male,female',
            'photo'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blood_group'       => 'nullable|string|max:10',
            'previous_school'   => 'nullable|string|max:255',
            'admission_date'    => 'required|date',
            'admission_number'  => 'required|string|max:20|unique:students,admission_number',
            'role'              => 'required|string|max:50',
            'religion'          => 'nullable|in:muslim,christian',
            'password'          => 'required|string|min:4',
        ]);

        // Set country to Nigeria if not provided
        $validatedData['country'] = 'Nigeria';

        // Generate a unique studentId in the format: SHORTNAME/STU/XXXX
        $schoolinfo = SchoolInfo::first();
        $short_name = $schoolinfo->short_name ?? 'SCH';

        $last_student = Student::orderBy('id', 'desc')->first();

        if ($last_student) {
            $last_studentId = $last_student->studentId;
            // Extract the last number part (after last '/')
            $last_number = (int) substr($last_studentId, strrpos($last_studentId, '/') + 1);
            $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
            $studentId = $last_number + 1;
        } else {
            $new_number = str_pad(1, 4, '0', STR_PAD_LEFT);
            $studentId = 1;
        }


        $validatedData['studentId'] = $short_name . '/STU/' . $new_number;

        // Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Handle photo upload if applicable
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $photo->store('front/images/student/', 'public');

            // Get the filename (this will include the folder path)
            $filename = $studentId . '.jpg'; // Use the student ID as the filename

            Storage::disk('public')->move($path, 'front/images/student/' . $filename);

            // Store the relative path (without 'public/' prefix)
            $validatedData['photo'] = 'front/images/student/' . $filename;
        }

        // Create the student record
        $student = Student::create($validatedData);

        return redirect()->route('admin.students.index')->with('success', 'Student record created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $schoolinfo = SchoolInfo::first();
        $classes = ClassModel::all();
        $parents = StudentParent::all();

        return view('admin.pages.students.edit', compact('schoolinfo', 'student', 'classes', 'parents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $schoolinfo = SchoolInfo::first();
        $classes = ClassModel::all();
        $parents = StudentParent::all();

        return view('admin.pages.students.edit', compact('schoolinfo', 'student', 'classes', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, \App\Models\Student $student)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'firstname'         => 'required|string|max:255',
            'middlename'        => 'nullable|string|max:255',
            'lastname'          => 'required|string|max:255',
            'dob'               => 'required|date',
            'address'           => 'nullable|string|max:500',
            'state'             => 'nullable|string|max:100',
            'country'           => 'nullable|string|max:100',
            'class_id'          => 'required|exists:classes,id',
            'parent_id'         => 'nullable|exists:parents,id',
            'gender'            => 'required|in:male,female',
            'photo'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blood_group'       => 'nullable|string|max:10',
            'previous_school'   => 'nullable|string|max:255',
            'admission_date'    => 'required|date',
            'admission_number'  => 'required|string|max:20|unique:students,admission_number,' . $student->id,
            'status'            => 'required|in:active,suspended',
            'role'              => 'required|string|max:50',
            'religion'          => 'nullable|in:muslim,christian',
            'password'          => 'nullable|string|min:4',
        ]);

        // Set country to Nigeria if not provided
        $validatedData['country'] = 'Nigeria';

        // Handle photo upload if applicable
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $photo->store('front/images/student/', 'public');

            // Get the filename (this will include the folder path)
            $filename = $student->id . '.jpg'; // Use the student ID as the filename

            Storage::disk('public')->move($path, 'front/images/student/' . $filename);

            // Store the relative path (without 'public/' prefix)
            $validatedData['photo'] = 'front/images/student/' . $filename;
        }

        // If password is provided, hash it
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // If no password is provided, keep the existing password
            unset($validatedData['password']);
        }

        // Update the student record
        $student->update($validatedData);

        return redirect()->route('admin.students.index')->with('success', 'Student record updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Delete the student record
        $student->delete();

        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        return redirect()->route('admin.students.index')->with('success', 'Student record deleted successfully.');
    }
}
