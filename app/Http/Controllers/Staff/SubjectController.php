<?php

namespace App\Http\Controllers\Staff;

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

            return view('staff.pages.subjects.index', compact('subjects', 'schoolinfo'));
        } else {

            $levels = Level::all();

            return view('staff.pages.subjects.index', compact('levels', 'schoolinfo'));
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

        return view('staff.pages.subjects.create', compact('schoolinfo', 'levels', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     */


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

        return view('staff.pages.subjects.edit', compact('subject', 'schoolinfo', 'levels', 'staffs'));
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

        return view('staff.pages.subjects.edit', compact('subject', 'schoolinfo', 'levels', 'staffs'));
    }

    /**
     * Update the specified resource in storage.
     */



}
