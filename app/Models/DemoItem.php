<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'page_id',
        'batch_no',
        'medicine_id',
        'qty',
        'dos',
    ];
}
