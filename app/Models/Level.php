<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{

     protected $fillable = [
        'level_name',
        'short_name',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'level_id');
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'level_id');
    }
}
