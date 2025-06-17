<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ExamQuestion;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Staff;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class ExamQuestionController extends Controller
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

            return view('admin.pages.examquestions.index', compact('subjects', 'schoolinfo'));
        } else {

            $levels = Level::all();

            return view('admin.pages.examquestions.index', compact('levels', 'schoolinfo'));
        }
    }

    public function getClasses($level)
    {
        $schoolinfo = SchoolInfo::first();

        // If a level is provided, filter subjects by that level
        if ($level) {
            $classes = ClassModel::where('level_id', $level)->orderBy('level_id', 'ASC')->orderBy('class_name', 'ASC')->get();

            return view('admin.pages.examquestions.index', compact('classes', 'schoolinfo'));
        } else {

            $levels = Level::all();

            return view('admin.pages.examquestions.index', compact('levels', 'schoolinfo'));
        }
    }

    public function getSubjects($level, $classId)
    {
        $schoolinfo = SchoolInfo::first();

        // If a level is provided, filter subjects by that level
        if ($level) {
            $subjects = Subject::where('level_id', $level)->orderBy('level_id', 'ASC')->orderBy('subject_name', 'ASC')->get();



            if(count($subjects) < 1){
                return redirect()->back()->with('success', 'Please add subjects for the designated class');
            }
            return view('admin.pages.examquestions.subjects', compact('subjects', 'schoolinfo', 'classId'));
        } else {

            $levels = Level::all();

            return view('admin.pages.examquestions.index', compact('levels', 'schoolinfo'));
        }
    }

    public function getClassName($classId)
    {
        // Fetch the class by ID
        $class = ClassModel::find($classId);

        if ($class) {
            // Return the class name
            return response()->json([
                'class_name' => $class->class_name,
            ]);
        } else {
            return response()->json([
                'class_name' => '',
            ], 404);
        }
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
     * Show the form for creating a new resource.
     */


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
