<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfo;
use App\Models\SessionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SchoolInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $sessions = SessionModel::orderBy('session_name', 'ASC')->get();
        return view('admin.pages.schoolinfo', compact('schoolinfo', 'sessions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id = '')
    {
        // Validate incoming data
        $validatedData = $request->validate([
            // Basic School Info
            'school_name'        => 'required|string|max:255',
            'short_name'         => 'nullable|string|max:100',
            'school_motto'       => 'nullable|string|max:255|unique:school_info,school_motto,' . $id,
            'school_type'        => 'required|in:primary,secondary,combined',
            'address'            => 'nullable|string',
            'city'               => 'nullable|string|max:100',
            'state'              => 'nullable|string|max:100',
            'lga'                => 'nullable|string|max:100',
            'country'            => 'nullable|string|max:100',
            'latitude'           => 'nullable|numeric|between:-90,90',
            'longitude'          => 'nullable|numeric|between:-180,180',
            'year_established'   => 'nullable|digits:4|integer|min:1800|max:' . date('Y'),
            'phone'              => 'nullable|string|max:20',
            'phone_alt'          => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:255',
            'meta_description'   => 'nullable|string',
            'meta_keywords'      => 'nullable|string',
            'facebook'           => 'nullable|url|max:255',
            'youtube'            => 'nullable|url|max:255',
            'whatsapp'           => 'nullable|string|max:100',
            'website'            => 'nullable|url|max:255',
            'google_map_src'     => 'nullable|string',

            //  New Session Fields
            'current_session'       => ['nullable', 'string', 'regex:/^\d{4}\/\d{4}$/', 'max:9'],
            'current_term'          => 'nullable|in:first,second,third',
            'session_start_date'    => 'nullable|date',
            'session_end_date'      => 'nullable|date|after_or_equal:session_start_date',
            'school_opened'         => 'nullable|integer|min:0',
            'next_term_begin_date'  => 'nullable|date|after_or_equal:session_end_date',
        ]);


        $validatedUploads = $request->validate([
            'logo_path'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon_path'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'darklogo_path'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retrieve the first SchoolInfo or find by provided id if necessary
        $SchoolInfo = empty($id) ? SchoolInfo::first() : SchoolInfo::findOrFail($id);

        // Handle file uploads if applicable
        if ($request->hasFile('logo_path')) {
            $logo = $request->file('logo_path');
            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $logo->store('front/images', 'public');

            // Get the filename (this will include the folder path)
            $filename = 'logo.png';

            // Rename the file to 'logo.png'
            Storage::disk('public')->move($path, 'front/images/' . $filename);

            // Store the relative path (without 'public/' prefix)
            $validatedData['logo_path'] = 'front/images/' . $filename;
        }


        // Store the favicon in the 'public/front/images' directory and name it 'favicon.png'
        if ($request->hasFile('favicon_path')) {
            $favicon = $request->file('favicon_path');
            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $favicon->store('front/images', 'public');

            // Get the filename (this will include the folder path)
            $filename = 'favicon.png';

            // Rename the file to 'favicon.png'
            Storage::disk('public')->move($path, 'front/images/' . $filename);

            // Store the relative path (without 'public/' prefix)
            $validatedData['favicon_path'] = 'front/images/' . $filename;
        }

        // Store the dark logo in the 'public/front/images' directory and name it 'white-logo.png'
        if ($request->hasFile('darklogo_path')) {
            $darklogo = $request->file('darklogo_path');
            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $darklogo->store('front/images', 'public');

            // Get the filename (this will include the folder path)
            $filename = 'white-logo.png';

            // Rename the file to 'white-logo.png'
            Storage::disk('public')->move($path, 'front/images/' . $filename);
        }


        Artisan::call('cache:clear');

        // Update the SchoolInfo record with validated data
        $SchoolInfo->update($validatedData);

        return redirect()->back()->with('success', 'School information updated successfully.');
    }
}
