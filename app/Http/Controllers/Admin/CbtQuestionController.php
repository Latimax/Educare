<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\CbtQuestion;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Staff;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CbtQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Level $level = null)
    {
          $schoolinfo = SchoolInfo::first();

        $junior_subjects = Subject::whereHas('level', function ($query) {
            $query->where('level_name', 'LIKE', '%junior%');
        })->get();

        $senior_subjects = Subject::whereHas('level', function ($query) {
            $query->where('level_name', 'LIKE', '%senior%');
        })->get();

        $levels = Level::all();

        $cbt_config = DB::table('cbt_configs')->first();

        return view('admin.pages.cbtquestions.index', compact('schoolinfo', 'junior_subjects', 'senior_subjects', 'levels', 'cbt_config'));

    }


    public function getContent($subjectId, $classId)
    {
        $schoolinfo = SchoolInfo::first();

        // Fetch the exam question by ID
        $examQuestion = ExamQuestion::where('subject_id', $subjectId)
            ->where('classes_id', $classId)
            ->first();

        // If a level is provided, filter subjects by that level

        if ($examQuestion) {
            // Return the content of the exam question
            return response()->json([
                'contents' => $examQuestion->contents,
                'attachments' => $examQuestion->attachments,
            ]);
        } else {
            //insert a new exam question
            $examQuestion = new ExamQuestion();
            $examQuestion->subject_id = $subjectId;
            $examQuestion->classes_id = $classId;
            $examQuestion->contents = '';
            $examQuestion->status = 'active'; // Default status
            $examQuestion->session = $schoolinfo->current_session;
            $examQuestion->term = $schoolinfo->current_term;
            $examQuestion->attachments = null; // Default attachments
            $examQuestion->save();

            return response()->json([
                'contents' => $examQuestion->contents,
                'attachments' => $examQuestion->attachments,
            ]);
        }
    }

    public function create()
    {

    }
    public function uploadImage(Request $request)
    {
        //Initialze array to hold uploaded image URLs
        if (!session()->has('image_paths')) {
            session(['image_paths' => []]);
        }

        if ($request->hasFile('file')) {

            $path = $request->file('file')->store('front/images/examuploads/', 'public');
            $url = Storage::url($path); // This is the line to check
            $url = str_replace('//', '/', $url);

            //Add the uploaded image URL to an array of image paths
            Session::push('image_paths', $url);

            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'classes_id' => 'required|exists:classes,id',
            'contents'   => 'required|string'
        ]);

        $schoolinfo = SchoolInfo::first();

        $subjectId = $request->input('subject_id');
        $classId = $request->input('classes_id');

        $paths = [];
        preg_match_all('/<img[^>]+src="([^"]+)"/i', $request->contents, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $path) {
                // Extract the part starting from 'front/'
                if (strpos($path, 'front/') !== false) {
                    $cleanPath = '/' . substr($path, strpos($path, 'front/'));
                    $paths[] = $cleanPath;
                }
            }
        }

        if (session()->has('image_paths')) {

            $imagePaths = session('image_paths', []);

            foreach ($imagePaths as $path) {
                //replace /storage with ''
                $path = str_replace('/storage', '', $path);

                //if $path is in the $paths array, then delete it
                if (in_array($path, $paths)) {
                    continue; // Skip deletion if the path is in the contents
                }
                Storage::disk('public')->delete($path);
            }
            // Clear session
            Session::forget('image_paths');
        }

        $examQuestion = ExamQuestion::where('subject_id', $subjectId)
            ->where('classes_id', $classId)
            ->first();

        // If a level is provided, filter subjects by that level

        if ($examQuestion) {
            // Update the existing exam question
            $examQuestion->contents = $request->input('contents');
            $examQuestion->attachments = $request->input('attachments', null); // Optional attachments
            $examQuestion->save();

            return redirect()->back()->with('success', 'Exam question updated successfully.');
        }

        // Set additional fields
        $validatedData['status'] = 'active'; // Default status
        $validatedData['session'] = $schoolinfo->current_session;
        $validatedData['term'] = $schoolinfo->current_term;
        $validatedData['attachments'] =  $request->input('attachments', null); // Optional attachments

        // Create the exam question
        ExamQuestion::create($validatedData);

        // Redirect with success message
        return redirect()->back()->with('success', 'Exam question created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject) {}
}
