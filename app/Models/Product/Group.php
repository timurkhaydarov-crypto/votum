<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product\Product;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\Product\GroupFactory> */
    use HasFactory;
    protected $casts = [
        'group' => 'array',
        'description' => 'array',
    ];

    protected $fillable = [
        'group',
        'image_url',
        'description',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
