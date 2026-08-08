<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Product\Category;
use App\Models\Product\Group;
use App\Models\Product\Brand;
use App\Models\Product\Sector;
use App\Models\Product\Method;

class Product extends Model
{
    use HasFactory;
    protected $casts = [
        'name' => 'array',
        'short_description' => 'array',
        'full_description' => 'array',
        'note' => 'array',
    ];
    protected $fillable = [
        'article',
        'name',
        'short_description',
        'full_description',
        'category_id',
        'group_id',
        'brand_id',
        'unit',
        'price',
        'quantity',
        'status',
        'note',
        'image_url',
        'video_url',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }    
    
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function sector(): HasOne
    {
        return $this->hasOne(Sector::class);
    }

    public function method(): HasOne
    {
        return $this->hasOne(Method::class);
    }
}
