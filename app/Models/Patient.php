<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'registration_date',
        'file_no',
        'registration_date',
        'first_name',
        'father_name',
        'gender',
        'date_of_birth',
        'uid_number',
        'other_id',
        'mobile_no',
        'alternative_no',
        'address',
        'Image',
    ];
    public function documents()
    {
        return $this->belongsTo(Documents::class);
    }
}
