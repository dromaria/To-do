<?php

namespace App\Repositories\Interfaces;

interface EmailRepositoryInterface
{
    public function storeCode(int $userID): string;
    public function getCode(int $userID): ?string;
}
