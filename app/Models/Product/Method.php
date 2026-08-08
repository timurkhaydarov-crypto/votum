<?php

namespace App\Models\Product;
use Database\Factories\Product\MethodFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product\Product;

class Method extends Model
{
    /** @use HasFactory<MethodFactory> */
    use HasFactory;
    protected $fillable = [
        'product_id',
        'ut_method',
        'et_method',
        'mia_method',
        'iet_method',
        'mt_method',
        'vt_method',
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
