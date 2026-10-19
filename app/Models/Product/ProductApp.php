<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductApp extends Model
{
    protected $casts = [
        'name' => 'array',
        'short_description' => 'array',
        'full_description' => 'array',
    ];

    protected $fillable = [
        'product_id',
        'name',
        'version',
        'purpose',
        'image',
        'short_description',
        'full_description',
    ];

    protected static function booted(): void
    {
        static::deleting(function (ProductApp $productApp): void {
            $productApp->images()->get()->each(
                fn (ProductAppImage $image) => $image->delete()
            );
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductAppImage::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
