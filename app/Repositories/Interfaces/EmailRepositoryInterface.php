<?php

namespace App\Repositories\Interfaces;

use App\DTO\User\VerifyUserDTO;

interface EmailRepositoryInterface
{
    public function storeCode(VerifyUserDTO $data): void;
    public function getCode(VerifyUserDTO $data): ?int;
    public function verifyCode(VerifyUserDTO $data, int $code): void;
}
