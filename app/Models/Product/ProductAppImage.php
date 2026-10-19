<?php

namespace App\Models\Product;

use App\Services\ProductMediaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class ProductAppImage extends Model
{
    protected $fillable = [
        'product_app_id',
        'image_url',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::deleted(function (ProductAppImage $image): void {
            $imagePath = $image->image_url;

            if (! str_starts_with($imagePath, 'product-apps/')) {
                return;
            }

            DB::afterCommit(function () use ($imagePath): void {
                if (self::query()->where('image_url', $imagePath)->exists()) {
                    return;
                }

                app(ProductMediaService::class)
                    ->deleteProductAppImage($imagePath);
            });
        });
    }

    public function productApp(): BelongsTo
    {
        return $this->belongsTo(ProductApp::class);
    }
}
