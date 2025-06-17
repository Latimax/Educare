<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_results';

    protected $fillable = ['student_id', 'class_id', 'average', 'position', 'session', 'term', 'resultData', 'total_time_present', 'handwriting', 'verbal', 'sports', 'drawing', 'craftwork', 'punctuality', 'regularity', 'neatness', 'politeness', 'honesty', 'cooperation', 'emotional', 'health', 'behaviour', 'attentiveness', 'class_teacher_comment', 'principal_comment', 'conduct', 'noofsubjectpass'];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

}
