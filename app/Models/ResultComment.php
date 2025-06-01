<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultComment extends Model
{

    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    // Table name (optional, if you want to use a custom table name)
    protected $table = 'result_comments';

    protected $fillable = [
        'comment',
        'grade_id',
    ];

    /**
     * Get the grade associated with the result comment.
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
