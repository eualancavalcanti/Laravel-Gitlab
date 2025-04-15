<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActorTag extends Model
{
    protected $fillable = ['actor_id', 'name'];
    
    public function actor()
    {
        return $this->belongsTo(Actor::class);
    }
}