<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Table name (optional, if you want to use a custom table name)
    protected $table = 'payments';

    // The attributes that are mass assignable.
    protected $fillable = [
        'reference',
        'student_id',
        'amount_paid',
        'purpose',
        'balance',
        'paid_by',
        'received_by',
        'payment_date',
        'payment_method',
        'status',
        'notes',
        'receipt_number',
        'session',
        'term',
    ];

    // Define any relationships if necessary
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
