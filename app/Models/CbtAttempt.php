<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CbtAttempt extends Model
{
    // Table name (optional, if you want to use a custom table name)
    protected $table = 'cbt_attempts';

    // The attributes that are mass assignable.

    protected $fillable = [
        'student_id',
        'subject_id',
        'class_id',
        'test_type',
        'questions',
        'start_time',
        'end_time',
        'is_submitted',
        'score',
        'correct',
        'wrong'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
