<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionHistory extends Model
{

    // Table name (optional, if you want to use a custom table name)
    protected $table = 'promotion_history';

    protected $fillable = [
        'student_id',
        'previous_class_id',
        'current_class_id',
        'promotion_date'
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function previousClass(){
        return $this->belongsTo(ClassModel::class, 'previous_class_id');
    }

    public function currentClass(){
        return $this->belongsTo(ClassModel::class, 'current_class_id');
    }

}
