<?php

namespace App\Models\Product;

use Database\Factories\Product\SectorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product\Product;

class Sector extends Model
{
    /** @use HasFactory<SectorFactory> */
    use HasFactory;
    protected $fillable = [
        'product_id',
        'railway',
        'aerospace',
        'oil',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
