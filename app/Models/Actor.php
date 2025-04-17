<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Actor extends Model
{
    protected $fillable = [
        'name', 'username', 'image', 'videos', 'followers', 'rating', 'featured'
    ];
    
    public function tags()
    {
        return $this->hasMany(ActorTag::class);
    }
    
    /**
     * Boot function para garantir que todos os atores tenham username
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($actor) {
            if (empty($actor->username)) {
                $actor->username = strtolower(Str::slug($actor->name));
            }
        });
        
        static::updating(function ($actor) {
            if (empty($actor->username)) {
                $actor->username = strtolower(Str::slug($actor->name));
            }
        });
    }
    
    /**
     * Acessor para obter o URL do perfil
     */
    public function getProfileUrlAttribute()
    {
        return route('creator.profile', ['username' => $this->username]);
    }
}