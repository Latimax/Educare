<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentScore extends Model
{
    protected $table = 'student_scores';

    protected $fillable = [
        'student_id',
        'subject_id',
        'term',
        'session',
        'first_test',
        'second_test',
        'exam',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
