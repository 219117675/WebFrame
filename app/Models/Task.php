<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 👈 import this
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory; // 👈 add this line

    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id', // 👈 include this if you're mass assigning
    ];
}

