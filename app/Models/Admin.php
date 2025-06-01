<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

     // Table name (optional, if you want to use a custom table name)
     protected $table = 'admins';

     // The attributes that are mass assignable.
     protected $fillable = [
         'name',
         'email',
         'password',
        'type', // Added the 'type' field
         'is_admin', // Added the 'is_admin' field
     ];

     protected $hidden = [
        'password',
        'remember_token',
    ];
}
