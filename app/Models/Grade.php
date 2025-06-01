<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'grade_name',
        'description',
        'min_score',
        'max_score',
    ];

    /**
     * Get the result comments associated with the grade.
     */
    public function resultComments()
    {
        return $this->hasMany(ResultComment::class);
    }

}
