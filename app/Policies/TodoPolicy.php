<?php

namespace App\Policies;

use App\Models\User;

class TodoPolicy
{
    public function check(User $user, int $userId): bool
    {
        return $user->id === $userId;
    }
}
