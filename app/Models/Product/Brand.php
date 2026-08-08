<?php

namespace App\Models\Product;

use Database\Factories\Product\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product\Product;

class Brand extends Model
{
    /** @use HasFactory<BrandFactory> */
    use HasFactory;
    protected $casts = [
        'brand' => 'array',
        'description' => 'array',
    ];
    protected $fillable = [
        'brand',
        'logo',
        'description'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
