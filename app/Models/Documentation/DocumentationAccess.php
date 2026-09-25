<?php

namespace App\Models\Documentation;

use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentationAccess extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'starts_at',
        'expires_at',
        'is_active',
        'last_accessed_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'last_accessed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class
        );
    }

    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $now = now();

        if (
            $this->starts_at &&
            $this->starts_at->isFuture()
        ) {
            return false;
        }

        if (
            $this->expires_at &&
            $this->expires_at->isPast()
        ) {
            return false;
        }

        return true;
    }
}