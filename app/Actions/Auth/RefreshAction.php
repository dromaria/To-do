<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class RefreshAction
{
    public function execute(): string
    {
        return Auth::refresh(true);
    }
}
