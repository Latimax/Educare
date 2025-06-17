<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{

    //Table
    protected $table = 'school_sessions';

     protected $fillable = [
        'session_name',
        'status',
    ];

}
