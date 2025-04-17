<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Creator extends Model
{
    protected $fillable = [
        'name', 'username', 'role', 'followers', 'likes', 'image', 'verified', 'trending'
    ];
    
    /**
     * Boot function para garantir que todos os criadores tenham username
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($creator) {
            if (empty($creator->username)) {
                $creator->username = strtolower(Str::slug($creator->name));
            }
        });
        
        static::updating(function ($creator) {
            if (empty($creator->username)) {
                $creator->username = strtolower(Str::slug($creator->name));
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