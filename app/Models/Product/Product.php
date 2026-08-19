<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Certificate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


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

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'product_group');
    }

    public function certificates(): BelongsToMany
        {
            return $this->belongsToMany(
                Certificate::class,
                'product_certificates',
                'product_id',
                'certificate_id'
            );
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
