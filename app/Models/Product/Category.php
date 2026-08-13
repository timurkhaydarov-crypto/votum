<?php

namespace App\Models\Product;

use Database\Factories\Product\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product\Product;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $casts = [
        'category' => 'array',
        'description' => 'array',
    ];

    protected $fillable = [
        'category',
        'slug',
        'image_url',
        'description',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
