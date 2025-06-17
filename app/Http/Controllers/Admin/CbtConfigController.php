<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CbtConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        return view('admin.pages.cbtconfigs.index', compact('schoolinfo', 'junior_subjects', 'senior_subjects', 'levels', 'cbt_config'));
    }


    public function toggleSubject(Request $request)
    {

        $subjectId = $request->input('subject_id');
        $active = $request->input('active') == "active" ? 'active' : 'disabled';


        $subject = Subject::find($subjectId);

        if (!$subject) {
            return response()->json(['message' => 'Subject not found.'], 404);
        }

        $subject->update(['status' => $active]);

        return response()->json(['message' => 'Subject status updated successfully.']);
    }

    public function updateScores(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'ft_min_score' => 'required|array',
            'ft_min_score.*' => 'required|integer|min:0|max:100',
            'ft_max_score' => 'required|array',
            'ft_max_score.*' => 'required|integer|min:0|max:100|gte:ft_min_score.*',
            'st_min_score' => 'required|array',
            'st_min_score.*' => 'required|integer|min:0|max:100',
            'st_max_score' => 'required|array',
            'st_max_score.*' => 'required|integer|min:0|max:100|gte:st_min_score.*',
            'exam_min_score' => 'required|array',
            'exam_min_score.*' => 'required|integer|min:0|max:100',
            'exam_max_score' => 'required|array',
            'exam_max_score.*' => 'required|integer|min:0|max:100|gte:exam_min_score.*',
        ]);

        foreach ($validatedData['ft_min_score'] as $levelId => $ftScore) {
            $level = Level::find($levelId);

            if ($level) {
                DB::table('levels')
                    ->where('id', $levelId)
                    ->update([
                        'ft_min_score' => $ftScore,
                        'ft_max_score' => $validatedData['ft_max_score'][$levelId] ?? 0,
                        'st_min_score' => $validatedData['st_min_score'][$levelId] ?? 0,
                        'st_max_score' => $validatedData['st_max_score'][$levelId] ?? 0,
                        'exam_min_score' => $validatedData['exam_min_score'][$levelId] ?? 0,
                        'exam_max_score' => $validatedData['exam_max_score'][$levelId] ?? 0,
                    ]);
            }
        }

        // Redirect back to the index with success message
        return redirect()->route('admin.cbtconfig.index')->with([
            'success' => 'CBT scores updated successfully.',
            'activeTab' => 'other'
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->index();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->index();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the fields
        $validatedData = $request->validate([
            'ft_status' => 'required',
            'st_status' => 'required',
            'exam_status' => 'required',
            'total_time' => 'required|integer|min:1',
            'attempts_allowed' => 'required|integer|min:1',
            'ft_total_questions' => 'required|integer|min:1',
            'st_total_questions' => 'required|integer|min:1',
            'exam_total_questions' => 'required|integer|min:1',
            'shuffle_questions' => 'nullable|in:on,off',
            'shuffle_answers' => 'nullable|in:on,off',
            'show_correct_answers' => 'nullable|in:on,off',
        ]);

        // Convert checkbox values to boolean
        $validatedData['shuffle_questions'] = $request->boolean('shuffle_questions');
        $validatedData['shuffle_answers'] = $request->boolean('shuffle_answers');
        $validatedData['show_correct_answers'] = $request->boolean('show_correct_answers');

        // Update the cbt_config table
        DB::table('cbt_configs')->update($validatedData);

        // Redirect back to the index with success message
        return redirect()->route('admin.cbtconfig.index')->with('success', 'CBT configuration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        // Delete the payment record
        $payment->delete();

        // Redirect back to payments index with success message
        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
    }
}
