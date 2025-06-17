<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionModel;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $sessions = SessionModel::orderBy('session_name', 'ASC')->get();

        return view('admin.pages.sessions.index', compact('schoolinfo', 'sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();
        $sessions = SessionModel::all();

        return view('admin.pages.sessions.create', compact('schoolinfo', 'sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate incoming data
        $validatedData = $request->validate([
            'session_name' => 'required|string|max:255|unique:school_sessions,session_name',
            'status' => 'in:active,disabled'
        ]);

        // Create a new class
        SessionModel::create($validatedData);


        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $schoolinfo = SchoolInfo::first();
        $sessionData = SessionModel::findOrFail($id);

        return view('admin.pages.sessions.edit', compact('schoolinfo', 'sessionData'));
    }

    public function show($id)
    {
        $schoolinfo = SchoolInfo::first();
        $sessionData = SessionModel::findOrFail($id);

        return view('admin.pages.sessions.edit', compact('schoolinfo', 'sessionData'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Fetch the class record
        $sessionData = SessionModel::findOrFail($id);

        // Validate input
        $validatedData = $request->validate([
            'session_name' => 'required|string|max:255|unique:school_sessions,session_name,'.$sessionData->id,
            'status' => 'in:active,disabled'
        ]);

        // Update class
        $sessionData->update($validatedData);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Fetch the class record
        $sessionData = SessionModel::findOrFail($id);

        // Delete the class
        $sessionData->delete();


        return redirect()->back()->with('success', 'Session deleted successfully.');
    }
}
