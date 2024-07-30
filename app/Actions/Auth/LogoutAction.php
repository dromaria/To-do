<?php

namespace App\Actions\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutAction
{
    public function execute(): void
    {
        JWTAuth::invalidate(true);
    }
}
