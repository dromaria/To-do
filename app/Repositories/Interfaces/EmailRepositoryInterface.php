<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface EmailRepositoryInterface
{
    public function storeCode(User $user): string;
    public function getCode(User $user): ?string;
    public function verifyCode(User $user, string $referenceCode, string $code): void;
}
