<?php

namespace App\Models\Product;

use App\Models\Cart\CartItem;
use App\Models\Request\RequestItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * Cart items.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Request items.
     */
    public function requestItems(): HasMany
    {
        return $this->hasMany(RequestItem::class);
    }

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

    public function gallery(): HasMany
    {
        return $this->hasMany(ProductGallery::class);
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

    public function features(): HasOne
    {
        return $this->hasOne(ProductFeatures::class);
    }

    public function specifications(): HasOne
    {
        return $this->hasOne(ProductSpecification::class);
    }

    /**
     * Products compatible with this product.
     */
    public function compatibleProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'product_compatibilities',
            'product_id',
            'compatible_product_id'
        );
    }

    /**
     * Products that are compatible with this product
     * from the opposite side of the pivot.
     */
    public function compatibleWithProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'product_compatibilities',
            'compatible_product_id',
            'product_id'
        );
    }

    /**
     * Get all products compatible with this product
     * regardless of the direction of the relation.
     */
    public function allCompatibleProducts()
    {
        return $this->compatibleProducts
            ->merge($this->compatibleWithProducts)
            ->unique('id')
            ->values();
    }
}
