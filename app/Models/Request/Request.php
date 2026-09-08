<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'number',
        'session_id',
        'subject',
        'name',
        'phone',
        'email',
        'comment',
        'context',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Request items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(
            RequestItem::class,
            'request_id'
        );
    }
}