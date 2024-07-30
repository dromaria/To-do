<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class AuthHelpers
{
    public static function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
}
