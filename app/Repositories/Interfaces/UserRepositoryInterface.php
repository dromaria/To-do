<?php

namespace App\Repositories\Interfaces;

use App\DTO\User\RegisterUserDTO;

interface UserRepositoryInterface
{
    public function register(RegisterUserDTO $data): void;
}
