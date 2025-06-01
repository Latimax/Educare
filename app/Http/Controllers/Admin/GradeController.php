<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $grades = Grade::all();

        return view('admin.pages.grades.index', compact('schoolinfo', 'grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();

        return view('admin.pages.grades.create', compact('schoolinfo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // Validate incoming data (grade_name, min_score, max_score, description)
        $validatedData = $request->validate([
            'grade_name' => 'required|string|max:255|unique:grades,grade_name',
            'min_score' => 'required|integer|min:0|max:100',
            'max_score' => 'required|integer|min:0|max:100|gte:min_score',
            'description' => 'nullable|string|max:500',
        ]);

        // Create a new grade
        Grade::create($validatedData);

        $schoolinfo = SchoolInfo::first();
        $grades = Grade::all();

        return view('admin.pages.grades.index', compact('schoolinfo', 'grades'))
            ->with('success', 'Grade created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        $schoolinfo = SchoolInfo::first();
        $grade = Grade::findOrFail($grade);

        return view('admin.pages.grades.edit', compact('schoolinfo', 'grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($grade)
    {
        $schoolinfo = SchoolInfo::first();
        $grade = Grade::findOrFail($grade);

        return view('admin.pages.grades.edit', compact('schoolinfo', 'grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'grade_name' => 'required|string|max:255|unique:grades,grade_name,' . $grade->id,
            'min_score' => 'required|integer|min:0|max:100',
            'max_score' => 'required|integer|min:0|max:100|gte:min_score',
            'description' => 'nullable|string|max:500',
        ]);

        // Update the grade
        $grade->update($validatedData);

        return redirect()->route('admin.grades.index')->with('success', 'Grade updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        // Delete the grade
        $grade->delete();

        return redirect()->route('admin.grades.index')->with('success', 'Grade deleted successfully.');
    }
}
