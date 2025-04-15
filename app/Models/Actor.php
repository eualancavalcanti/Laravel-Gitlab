<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = [
        'name', 'image', 'videos', 'followers', 'rating', 'featured'
    ];
    
    public function tags()
    {
        return $this->hasMany(ActorTag::class);
    }
}