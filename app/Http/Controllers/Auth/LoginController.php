<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Неверные учетные данные',
            ], 401);
        }
        
        $request->session()->regenerate();

        $user = Auth::user();

        return response()->json([
            'message' => 'Вход выполнен успешно',
            'user' => $user,
        ]);
    }
}
