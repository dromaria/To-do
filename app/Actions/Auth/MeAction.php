<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class MeAction
{
    public function execute(): User|Authenticatable|null
    {
        return Auth::user();
    }
}
