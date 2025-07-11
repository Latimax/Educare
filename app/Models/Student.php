<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $table = 'students'; // Specify the table name if it's not the default 'students'

    protected $fillable = [
        'studentId',
        'firstname',
        'middlename',
        'lastname',
        'dob',
        'address',
        'state',
        'country',
        'class_id',
        'parent_id',
        'gender',
        'photo',
        'blood_group',
        'previous_school',
        'admission_date',
        'admission_number',
        'status',
        'role',
        'religion',
        'password',
    ];

    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }

    public function studentClass()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    //Get student fullname by concatenating firstname, middlename, and lastname
    public function getFullNameAttribute()
    {
        return trim("{$this->firstname} {$this->middlename} {$this->lastname}");
    }

    // Get the student's age
    public function getAgeAttribute()
    {
        return now()->diffInYears($this->dob);
    }

    //Student payments relationship
    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    // Student result relationship
    public function results()
{
    return $this->hasMany(StudentResult::class);
}
}
