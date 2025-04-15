<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    protected $fillable = [
        'name', 'role', 'followers', 'likes', 'image', 'verified', 'trending'
    ];
}