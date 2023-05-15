<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d-m-y h:i',
    ];

    protected $fillable = ['title', 'content'];
}
