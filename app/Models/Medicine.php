<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'price',
        'stock',
        'name'
    ];


    // public function user() {
    //     return $this->belongsTo(User::class, 'medicine_id', 'user_id');
    // }
}
