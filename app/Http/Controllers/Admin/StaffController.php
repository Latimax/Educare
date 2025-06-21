<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Staff;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $staffs = Staff::all();

        return view('admin.pages.staffs.index', compact('schoolinfo', 'staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();
        $levels = Level::all();

        return view('admin.pages.staffs.create', compact('schoolinfo', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'fullname'              => 'required|string|max:255',
            'password'              => 'required|string|min:4', // Require password for new staff
            'email'                 => 'required|email|unique:staffs,email',
            'photo'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'                => 'required|in:active,disabled',
            'user_type'             => 'required|in:teacher,non-teaching,cleaner,driver,other,security',
            'phone'                 => 'nullable|string|max:20',
            'dob'                   => 'nullable|date',
            'state'                 => 'nullable|string|max:100',
            'country'               => 'nullable|string|max:100',
            'gender'                => 'required|in:male,female,other',
            'highest_qualification' => 'nullable|string|max:255',
            'position'              => 'nullable|string|max:255',
            'department'            => 'nullable|string|max:255',
            'employment_date'       => 'nullable|date',
            'subject_specialty'     => 'nullable|string|max:255',
        ]);


        //Generate a unique staff ID based on the school's short name
        $schoolinfo = SchoolInfo::first();
        $short_name = $schoolinfo->short_name;

        // Get the last staff created to generate a unique staff ID
        $last_staff = Staff::orderBy('id', 'desc')->first();
        // If there are no staff records, start with 001
        if ($last_staff) {
            $last_staffId = $last_staff->staffId;
            $last_staff_number = (int) substr($last_staffId, strrpos($last_staffId, '/') + 1);
            $new_staff_number = str_pad($last_staff_number + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $new_staff_number = '001';
        }

        // Create the staff ID in the format: SHORTNAME/YEAR/STAFFNUMBER
        $validatedData['staffId'] = $short_name  . '/STF/' . $new_staff_number;


        // Always hash the password for new staff
        $validatedData['password'] = Hash::make($validatedData['password']);


        // If a photo was uploaded, rename it using staff ID for consistency
        // Handle photo upload if applicable
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $photo->store('front/images/staff/', 'public');

            // Get the filename (this will include the folder path)
            $filename = $new_staff_number . '.jpg'; // Use the staff ID as the filename

            Storage::disk('public')->move($path, 'front/images/staff/' . $filename);

            // Store the relative path (without 'public/' prefix)
            $validatedData['photo'] = 'front/images/staff/' . $filename;
        }

        // Create the staff record
        $staff = Staff::create($validatedData);


        return redirect()->route('admin.staffs.index')->with('success', 'Staff record created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        $schoolinfo = SchoolInfo::first();
        $levels = Level::all();
        $subjects = Subject::where("staff_id", $staff->id)->get();
        return view('admin.pages.staffs.show', compact('schoolinfo', 'staff', 'levels', 'subjects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        $schoolinfo = SchoolInfo::first();
        $levels = Level::all();

        return view('admin.pages.staffs.edit', compact('schoolinfo', 'staff', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {


        // Validate incoming data
        $validatedData = $request->validate([
            'fullname'              => 'required|string|max:255',
            'password'              => 'nullable|string|min:4',
            'email'                 => 'required|email|unique:staffs,email,' . $staff->id,
            'photo'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'                => 'required|in:active,disabled',
            'user_type'             => 'required|in:teacher,non-teaching,cleaner,driver,other,security',
            'phone'                 => 'nullable|string|max:20',
            'dob'                   => 'nullable|date',
            'state'                 => 'nullable|string|max:100',
            'country'               => 'nullable|string|max:100',
            'gender'                => 'required|in:male,female,other',
            'highest_qualification' => 'nullable|string|max:255',
            'position'              => 'nullable|string|max:255',
            'department'            => 'nullable|string|max:255',
            'employment_date'       => 'nullable|date',
            'subject_specialty'     => 'nullable|string|max:255',
        ]);

        // Handle photo upload if applicable
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $photo->store('front/images/staff/', 'public');

            // Get the filename (this will include the folder path)
            $filename = $staff->id . '.jpg'; // Use the staff ID as the filename

            Storage::disk('public')->move($path, 'front/images/staff/' . $filename);

            // Store the relative path (without 'public/' prefix)
            $validatedData['photo'] = 'front/images/staff/' . $filename;
        }

        // If password is provided, hash it
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // If no password is provided, keep the existing password
            unset($validatedData['password']);
        }

        // Create the staff record
        $staff->update($validatedData);

        return redirect()->route('admin.staffs.index')->with('success', 'Staff record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        // Delete the staff record
        $staff->delete();

        if ($staff->photo) {
           Storage::disk('public')->delete($staff->photo);
        }

        return redirect()->route('admin.staffs.index')->with('success', 'Staff record deleted successfully.');
    }
}
