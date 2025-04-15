<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title', 'thumbnail', 'progress', 'viewers', 
        'duration', 'remaining_time', 'trending'
    ];
    
    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}