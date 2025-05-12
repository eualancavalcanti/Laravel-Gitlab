<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPerViewPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'transaction_id',
        'amount',
        'payment_method',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Obtém o usuário que realizou esta compra
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtém o item PPV relacionado a esta compra
     */
    public function item()
    {
        return $this->belongsTo(PayPerViewItem::class, 'item_id');
    }

    /**
     * Verifica se esta compra está ativa (dentro do período de validade)
     */
    public function isActive()
    {
        return $this->status === 'completed' && $this->expires_at > now();
    }
}
