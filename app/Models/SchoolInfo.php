<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolInfo extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolInfoFactory> */
    use HasFactory;

    // Table name (optional, if you want to use a custom table name)
    protected $table = 'school_info';

    // The attributes that are mass assignable.
    protected $fillable = [
    'name',
    'address',
    'phone',
    'email',
    'website',
    'logo',
    'school_motto',
    'established_year',
    'owner_name',

    // Session-related fields
    'current_session',
    'current_term',
    'session_start_date',
    'session_end_date',
    'school_opened',
    'next_term_begin_date',
];


}
