<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\ClassModel;
use App\Models\SchoolInfo;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $classes = ClassModel::orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();

        return view('admin.pages.classes.index', compact('schoolinfo', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();
        $levels = Level::all();
        $staffs =  Staff::where('user_type', 'teacher')->get();

        return view('admin.pages.classes.create', compact('schoolinfo', 'levels', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate incoming data
        $validatedData = $request->validate([
            'class_name' => 'required|string|max:255|unique:classes,class_name',
            'section' => 'required|string|in:A,B,C,D,E',
            'class_teacher_id' => 'nullable|exists:staffs,id|unique:classes,class_teacher_id',
            'level_id' => 'required|exists:levels,id',
        ]);

        // Create a new class
        ClassModel::create($validatedData);


        return redirect()->route('admin.classes.index')
            ->with('success', 'Class created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($classId)
    {
        $schoolinfo = SchoolInfo::first();
        $class = ClassModel::findOrFail($classId);
        $levels = Level::all();
        $staffs = Staff::where('user_type', 'teacher')->get();

        return view('admin.pages.classes.edit', compact('schoolinfo', 'class', 'levels', 'staffs'));
    }

    public function show($classId)
    {
        $schoolinfo = SchoolInfo::first();
        $class = ClassModel::findOrFail($classId);
        $levels = Level::all();
        $staffs = Staff::where('user_type', 'teacher')->get();

        return view('admin.pages.classes.edit', compact('schoolinfo', 'class', 'levels', 'staffs'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Fetch the class record
        $class = ClassModel::findOrFail($id);

        // Validate input
        $validatedData = $request->validate([
            'class_name' => 'required|string|max:255|unique:classes,class_name,' . $class->id,
            'section' => 'required|string|in:A,B,C,D,E',
            'level_id' => 'required|exists:levels,id',
            'class_teacher_id' => [
                'nullable',
                'exists:staffs,id',
                Rule::unique('classes', 'class_teacher_id')->ignore($class->id),
            ],
        ]);

        // Update class
        $class->update($validatedData);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Fetch the class record
        $class = ClassModel::findOrFail($id);

        //Check if the class has any students enrolled
        if ($class->students()->count() > 0) {
            return redirect()->route('admin.classes.index')->with('success', 'Cannot delete class with enrolled students.');
        }

        // Delete the class
        $class->delete();


        return redirect()->back()->with('success', 'Class deleted successfully.');

    }

}
