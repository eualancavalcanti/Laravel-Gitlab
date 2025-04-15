<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'title', 'description', 'date', 'image', 'cta_text', 
        'cta_link', 'active', 'order'
    ];
}