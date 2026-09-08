<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
    ];

    /**
     * Cart items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}