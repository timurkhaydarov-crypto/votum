<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDocumentationAccess
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $userId = $request->session()->get(
            'documentation_user_id'
        );

        $keyHash = $request->session()->get(
            'documentation_key_hash'
        );

        if (! $userId || ! $keyHash) {
            return response()->json([
                'message' =>
                    'Documentation authentication required.',
            ], 401);
        }

        $user = User::query()
            ->where('id', $userId)
            ->where('role', 'user')
            ->first();

        if (
            ! $user ||
            ! $user->documentation_key_hash ||
            ! hash_equals(
                $user->documentation_key_hash,
                $keyHash
            )
        ) {
            $request->session()->forget([
                'documentation_user_id',
                'documentation_key_hash',
            ]);

            return response()->json([
                'message' =>
                    'Documentation access is no longer valid.',
            ], 401);
        }

        $request->attributes->set(
            'documentation_user',
            $user
        );

        return $next($request);
    }
}