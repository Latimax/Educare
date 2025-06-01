<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\ResultComment;
use App\Models\SchoolInfo;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();

        $comments = ResultComment::with(['grade'])->get();

        return view('admin.pages.resultcomments.index', compact('schoolinfo', 'comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolinfo = SchoolInfo::first();

        $grades = Grade::all();

        return view('admin.pages.resultcomments.create', compact('schoolinfo', 'grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data with unique constraint for reference
        $validated = $request->validate([
            'comment'         => 'required|string|max:255|unique:result_comments,comment',
            'grade_id'        => 'required|exists:grades,id',
        ]);

        ResultComment::create($validated);

        // Fetch updated comments list with relationships
        $comments = ResultComment::all();
        $schoolinfo = SchoolInfo::first();

        // Redirect back to comments index with success message
        return view('admin.pages.resultcomments.index', compact('schoolinfo', 'comments'))->with('success', 'ResultComment created successfully for student.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ResultComment $resultcomment)
    {
        $comment = ResultComment::findOrFail($resultcomment->id);

        $schoolinfo = SchoolInfo::first();

        // Get all grades for the dropdown
        $grades = Grade::all();

        return view('admin.pages.resultcomments.edit', compact('schoolinfo', 'comment', 'grades'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResultComment $resultcomment)
    {
        $comment = ResultComment::findOrFail($resultcomment->id);

        $schoolinfo = SchoolInfo::first();

        // Get all grades for the dropdown
        $grades = Grade::all();

        return view('admin.pages.resultcomments.edit', compact('schoolinfo', 'comment', 'grades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResultComment $resultcomment)
    {

        // Validate form data with unique constraint for reference except for the current comment
        $validated = $request->validate([
            'comment'         => 'required|string|max:255',
            'grade_id'        => 'required|exists:grades,id',
        ]);

        // Update comment
        $resultcomment->update($validated);

        return redirect()->route('admin.resultcomments.index')
            ->with('success', 'Result Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResultComment $resultcomment)
    {
        // Delete the comment record
        $resultcomment->delete();

        // Redirect back to comments index with success message
        return redirect()->route('admin.resultcomments.index')->with('success', 'Result Comment deleted successfully.');
    }
}
