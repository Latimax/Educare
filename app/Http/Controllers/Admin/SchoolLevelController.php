<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;

class SchoolLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $levels = Level::all();

        return view('admin.pages.levels.index', compact('schoolinfo', 'levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();

        return view('admin.pages.levels.create', compact('schoolinfo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // Validate incoming data
        $validatedData = $request->validate([
            'level_name' => 'required|string|max:255|unique:levels,level_name',
            'short_name' => 'required|string|max:5|unique:levels,short_name',
            'status' => 'required|string|in:active,disabled',
        ]);

        // Create a new level
        Level::create($validatedData);

        $schoolinfo = SchoolInfo::first();
        $levels = Level::all();

        return view('admin.pages.levels.index', compact('schoolinfo', 'levels'))
            ->with('success', 'Level created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($level)
    {
        $schoolinfo = SchoolInfo::first();
        $level = Level::findOrFail($level);

        return view('admin.pages.levels.edit', compact('schoolinfo', 'level'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'level_name' => 'required|string|max:255|unique:levels,level_name,' . $level->id,
            'short_name' => 'required|string|max:5|unique:levels,short_name,' . $level->id,
            'status' => 'required|string|in:active,disabled',
        ]);

        // Update the level
        $level->update($validatedData);

        return redirect()->route('admin.levels.index')->with('success', 'Level updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        // Delete the level
        $level->delete();

        return redirect()->route('admin.levels.index')->with('success', 'Level deleted successfully.');
    }
}
