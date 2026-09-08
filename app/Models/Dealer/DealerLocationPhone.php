<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealerLocationPhone extends Model
{
    protected $fillable = [
        'dealer_location_id',
        'phone',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Dealer location.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(
            DealerLocation::class,
            'dealer_location_id'
        );
    }
}