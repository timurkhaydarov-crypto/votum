<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCompatibility extends Model
{
    protected $table = 'product_compatibilities';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'compatible_product_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
        );
    }

    public function compatibleProduct(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'compatible_product_id',
        );
    }
}
