<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Certificate extends Model
{
    use HasFactory;

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    protected $fillable = [
        'title',
        'image_url',
        'description',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_certificates',
            'certificate_id',
            'product_id'
        );
    }
}