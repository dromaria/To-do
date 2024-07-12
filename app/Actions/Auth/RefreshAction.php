<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class RefreshAction
{
    public function execute(): array
    {
        $token = Auth::refresh(true);

        return AuthHelpers::respondWithToken($token);
    }
}
