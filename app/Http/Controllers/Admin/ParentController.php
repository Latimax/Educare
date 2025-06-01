<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentParent;
use App\Models\ClassModel;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $parents = StudentParent::with('children')->get();

        return view('admin.pages.parents.index', compact('schoolinfo', 'parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();

        return view('admin.pages.parents.create', compact('schoolinfo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate incoming data
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'nullable|email|unique:parents,email',
            'password' => 'nullable|string|min:4',
            'occupation' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20|unique:parents,phone',
            'relationship' => 'required|string|in:parent,guardian',
        ]);


        // Hash the password
        $validatedData['password'] = $validatedData['password'] == null ? bcrypt('1234') : bcrypt($validatedData['password']);

        // Create a new parent
        StudentParent::create($validatedData);

        // Fetch necessary data for the view
        $schoolinfo = SchoolInfo::first();
        $parents = StudentParent::all();

        return view('admin.pages.parents.index', compact('schoolinfo', 'parents'))
            ->with('success', 'Parent created successfully.');
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
    public function edit($parent)
    {
        $schoolinfo = SchoolInfo::first();
        $parent = StudentParent::findOrFail($parent);

        return view('admin.pages.parents.edit', compact('schoolinfo', 'parent'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, StudentParent $parent)
{
    // Validate incoming data
    $validatedData = $request->validate([
        'fullname' => 'required|string|max:255',
        'email' => 'nullable|email|unique:parents,email,' . $parent->id,
        'occupation' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'nationality' => 'nullable|string|max:255',
        'phone' => 'required|string|max:20|unique:parents,phone,' . $parent->id,
        'relationship' => 'required|string|in:parent,guardian',
    ]);

    // Update the parent
    $parent->update($validatedData);

    return redirect()->route('admin.parents.index')->with('success', 'Parent updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(StudentParent $parent) {
    // Delete the parent record
    $parent->delete();

    // Redirect back to the index with a success message
    return redirect()->route('admin.parents.index')->with('success', 'Parent deleted successfully.');
   }
}
