<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductDocument extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class
        );
    }

    public function files(): HasMany
    {
        return $this->hasMany(
            ProductDocumentFile::class
        );
    }
}