<?php

namespace App\Models;

use Illuminate\Bus\Batch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'rate',
        'tax',
    ];
    // public function batches()
    // {
    //     return $this->hasMany(Batch::class);
    // }
}
