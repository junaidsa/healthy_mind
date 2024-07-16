<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documents extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'user_id',
        'file_no',
        'registration_date',
        'first_name',
        'father_name',
        'gender',
        'uid_number',
        'other_id',
        'mobile_no',
        'date_of_birth',
        'alternative_no',
        'address',
        'Image',
    ];
}
