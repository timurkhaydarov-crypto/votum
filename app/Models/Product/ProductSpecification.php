<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpecification extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'value',
    ];

    protected $casts = [
        'name' => 'array',
        'value' => 'array',
    ];

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
        );
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}