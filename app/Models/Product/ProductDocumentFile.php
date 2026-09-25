<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDocumentFile extends Model
{
    protected $fillable = [
        'product_document_id',
        'locale',
        'original_name',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    protected $hidden = [
        'file_path',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(
            ProductDocument::class,
            'product_document_id'
        );
    }
}