<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    // Table name (optional, if you want to use a custom table name)
    protected $table = 'staffs';

    protected $fillable = [
        'fullname',
        'staffId',
        'email',
        'password',
        'photo',
        'status',
        'user_type',
        'phone',
        'dob',
        'state',
        'country',
        'gender',
        'highest_qualification',
        'position',
        'department',
        'employment_date',
        'subject_specialty',
    ];

    public function department()
    {
        return $this->belongsTo(Level::class, 'department');
    }

     public function departmentLevel()
    {
        return $this->belongsTo(Level::class, 'department');
    }

}


