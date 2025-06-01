<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
     use HasFactory;

    protected $table = 'parents'; // because table name is 'parents'

    protected $fillable = [
        'fullname',
        'email',
        'occupation',
        'state',
        'nationality',
        'phone',
        'relationship',
        'password',
    ];

    public function children()
{
    return $this->hasMany(Student::class, 'parent_id');
}
}
