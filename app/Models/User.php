<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Documentation\DocumentationAccess;
use App\Models\Product\Product;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token','documentation_key_hash'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function documentationAccesses(): HasMany
    {
        return $this->hasMany(
            DocumentationAccess::class
        );
    }

    public function documentationProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'documentation_accesses'
        )
            ->withPivot([
                'starts_at',
                'expires_at',
                'is_active',
                'last_accessed_at',
            ])
            ->withTimestamps();
    }
}
