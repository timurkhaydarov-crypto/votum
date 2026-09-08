<?php

namespace App\Models\Request;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestItem extends Model
{
    use HasFactory;

    protected $table = 'request_items';

    protected $fillable = [
        'request_id',
        'product_id',
        'article',
        'product_name',
        'quantity',
    ];

    protected $casts = [
        'product_name' => 'array',
        'quantity' => 'integer',
    ];

    /**
     * Parent request.
     */
    public function request(): BelongsTo
    {
        return $this->belongsTo(
            Request::class,
            'request_id'
        );
    }

    /**
     * Product.
     *
     * Nullable because the product can be deleted
     * while the request must remain in history.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }
}
