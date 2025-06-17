<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // Table name (optional, if you want to use a custom table name)
    protected $table = 'subjects';

    // The attributes that are mass assignable.
    protected $fillable = [
        'subject_name',
        'subject_code',
        'staff_id',
        'level_id',
        'status'
    ];

    // Define any relationships if necessary
    public function Level()
    {
        return $this->belongsTo(Level::class);
    }

    public function Staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function cbtQuestions()
    {
        return $this->hasMany(CbtQuestion::class, 'subject_id');
    }

    public function classes()
    {
        // Many-to-many relationship with classes via pivot table
        return $this->belongsToMany(ClassModel::class,'classes', 'subject_id', 'classes_id')
            ->withPivot('id'); // Include pivot table fields if needed
    }
}
