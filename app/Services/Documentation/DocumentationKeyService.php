<?php

namespace App\Services\Documentation;

use App\Models\User;
use Illuminate\Support\Str;

class DocumentationKeyService
{
    public function rotate(User $user): string
    {
        $key = Str::random(64);

        $user->forceFill([
            'documentation_key_hash' => hash(
                'sha256',
                $key
            ),
        ])->save();

        return $key;
    }

    public function revoke(User $user): void
    {
        $user->forceFill([
            'documentation_key_hash' => null,
        ])->save();
    }

    public function resolveUser(string $key): ?User
    {
        $hash = hash(
            'sha256',
            $key
        );

        return User::query()
            ->where('role', 'user')
            ->where(
                'documentation_key_hash',
                $hash
            )
            ->first();
    }
}