<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    // Table name (optional, if you want to use a custom table name)
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'section',
        'class_teacher_id',
        'status',
        'level_id',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'class_teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function cbtQuestions()
    {
        return $this->hasMany(CbtQuestion::class, 'classes_id');
    }

    //Classes has several student results
    public function studentResults()
    {
        return $this->hasMany(StudentResult::class, 'class_id');
    }
}
