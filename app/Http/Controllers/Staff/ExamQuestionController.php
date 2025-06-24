<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ExamQuestion;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class ExamQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $staffId = Auth::guard('staff')->user()->id;

        // Get all level_ids from subjects taught by the staff
        $subjectLevelIds = Subject::where('staff_id', $staffId)
            ->pluck('level_id')
            ->unique();

        // Get classes either taught or class-teachered by the staff
        $classes = ClassModel::where('class_teacher_id', $staffId)
            ->orWhereIn('level_id', $subjectLevelIds)
            ->get()
            ->unique('id')     // Remove duplicates by class id
            ->values();        // Reset array keys

        return view('staff.pages.examquestions.index', compact('classes', 'schoolinfo'));
    }


    public function getClasses($level)
    {
        $this->index();
    }
    public function getSubjects($level, $classId)
    {
        $schoolinfo = SchoolInfo::first();
        $staffId = Auth::guard('staff')->user()->id;

        // Fetch the class and its name
        $class = ClassModel::with('level')->find($classId); // Assuming ClassModel has a 'level' relationship
        if (!$class) {
            return redirect()->back()->with('error', 'Class not found.');
        }

        $className = $class->class_name;
        $levelName = optional($class->level)->level_name ?? ''; // Safely get level name

        if ($level) {
            // If staff is class teacher and level is not Secondary
            if ($class->class_teacher_id == $staffId && !str_contains(strtolower($levelName), 'secondary')) {
                // Fetch all subjects for the level
                $subjects = Subject::where('level_id', $level)
                    ->orderBy('level_id', 'ASC')
                    ->orderBy('subject_name', 'ASC')
                    ->get();
            } else {
                // Fetch only subjects assigned to this staff
                $subjects = Subject::where('level_id', $level)
                    ->where('staff_id', $staffId)
                    ->orderBy('level_id', 'ASC')
                    ->orderBy('subject_name', 'ASC')
                    ->get();
            }

            if ($subjects->isEmpty()) {
                return redirect()->back()->with('success', 'No subjects available for this class level.');
            }

            return view('staff.pages.examquestions.subjects', compact('subjects', 'schoolinfo', 'classId', 'className'));
        } else {
            return $this->index(); // redirect to index properly
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
}
