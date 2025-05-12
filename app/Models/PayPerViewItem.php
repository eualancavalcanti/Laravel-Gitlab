<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPerViewItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'preview_url',
        'full_video_url',
        'duration',
        'category',
        'price',
        'creator_id',
        'is_active',
    ];

    /**
     * Obtém o criador deste item PPV
     */
    public function creator()
    {
        return $this->belongsTo(Creator::class);
    }

    /**
     * Obtém todas as compras deste item PPV
     */
    public function purchases()
    {
        return $this->hasMany(PayPerViewPurchase::class, 'item_id');
    }

    /**
     * Verifica se um usuário específico comprou este item
     */
    public function isPurchasedBy($userId)
    {
        return $this->purchases()
            ->where('user_id', $userId)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
