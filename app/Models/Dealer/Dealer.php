<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dealer extends Model
{
    protected $fillable = [
        'country',
        'flag',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Dealer locations.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(DealerLocation::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}

