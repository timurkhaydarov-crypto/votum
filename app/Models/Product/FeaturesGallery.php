<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Database\Factories\Product\FeaturesGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductFeatures;

class FeaturesGallery extends Model
{
    /** @use HasFactory<FeaturesGalleryFactory> */
    use HasFactory;

    protected $casts = [
        'title' => 'array',
    ];

    protected $fillable = [
        'features_id',
        'title',
        'image_url',
    ];

    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
        );
    }

    public function features(): BelongsTo
    {
        return $this->belongsTo(
            ProductFeatures::class,
            'features_id'
        );
    }
}
