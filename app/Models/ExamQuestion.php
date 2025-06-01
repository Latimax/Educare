<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    // Table name (optional, if you want to use a custom table name)
    protected $table = 'exam_questions';

    // The attributes that are mass assignable.

    protected $fillable = [
        'subject_id',
        'classes_id',
        'contents',
        'status',
        'session',
        'term',
        'attachments',
    ];

    /**
     * Get the subject associated with the exam question.
     */
    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the class associated with the exam question.
     */
    public function class() {
        return $this->belongsTo(ClassModel::class, 'classes_id');
    }

}
