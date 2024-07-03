<?php

namespace App\Repositories\Interfaces;

use App\DTO\User\UserDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function register(UserDTO $data): User;
}
