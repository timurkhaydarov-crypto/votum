<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product\Product;

class ProductFeatures extends Model
{
    /** @use HasFactory<\Database\Factories\Product\ProductFeaturesFactory> */
    use HasFactory;
    protected $casts = [
        'features' => 'array',
    ];

    protected $fillable = [
        'product_id',    
        'features',
    ];
    public function setFeaturesAttribute($value): void
    {
        $this->attributes['features'] = json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
        );
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
