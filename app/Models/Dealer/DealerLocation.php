<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DealerLocation extends Model
{
    protected $fillable = [
        'dealer_id',
        'address',
        'website',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Dealer.
     */
    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
     * Location phones.
     */
    public function phones(): HasMany
    {
        return $this->hasMany(DealerLocationPhone::class)
            ->orderBy('sort_order');
    }
}

