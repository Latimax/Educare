<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Staff;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Level $level = null)
    {
        $schoolinfo = SchoolInfo::first();

        // If a level is provided, filter subjects by that level
        if ($level) {
            $subjects = Subject::where('level_id', $level->id)->with(['Level'])->get();

            return view('admin.pages.subjects.index', compact('subjects', 'schoolinfo'));
        } else {

            $levels = Level::all();

            return view('admin.pages.subjects.index', compact('levels', 'schoolinfo'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();

        // Fetch levels for the dropdown
        $levels = Level::all();

        //Fetch staff for the dropdown
        $staffs = Staff::all();

        return view('admin.pages.subjects.create', compact('schoolinfo', 'levels', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:50',
            'staff_id'     => 'required|exists:staffs,id',
            'level_id'     => 'required|exists:levels,id',
        ]);

        // Create the subject
        Subject::create($validated);

        // Redirect with success message
        return redirect()->route('admin.subjects.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $schoolinfo = SchoolInfo::first();

        // Load the level relationship
        $subject->load('Level');

        // Fetch levels for the dropdown
        $levels = Level::all();

        //Fetch staff for the dropdown
        $staffs = Staff::all();

        return view('admin.pages.subjects.edit', compact('subject', 'schoolinfo', 'levels', 'staffs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $schoolinfo = SchoolInfo::first();

        // Load the level relationship
        $subject->load('Level');

        // Fetch levels for the dropdown
        $levels = Level::all();

        //Fetch staff for the dropdown
        $staffs = Staff::all();

        return view('admin.pages.subjects.edit', compact('subject', 'schoolinfo', 'levels', 'staffs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        // Validate form data
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:6',
            'staff_id'     => 'required|exists:staffs,id',
            'level_id'     => 'required|exists:levels,id',
            'status'       => 'required|in:active,disabled',
        ]);


        // Update the subject
        $subject->update($validated);

        // Redirect with success message
        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // Delete the subject
        $subject->delete();

        // Redirect with success message
        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
