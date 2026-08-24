<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product\Product;

class ProductGallery extends Model
{
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    protected $fillable = [
        'product_id',    
        'title',
        'image_url',
        'description',
    ];

    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
        );
    }

    public function setDescriptionAttribute($value): void
    {
        $this->attributes['description'] = json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
