<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientBills extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'user_id',
        'patient_id',
        'total_amount',
        'bill_data',
        'bill_data',
        'bill_no',
        'tax_sale',
        'bill_no',
        'note',
    ];
}
