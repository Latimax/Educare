<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CbtQuestion extends Model
{
    // Table name (optional, if you want to use a custom table name)
    protected $table = 'cbt_questions';

    // The attributes that are mass assignable.

    protected $fillable = [
        'subject_id',
        'classes_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'answer',
        'status',
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
