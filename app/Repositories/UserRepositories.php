<?php

namespace App\Repositories;

use App\DTO\User\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepositories implements UserRepositoryInterface
{
    public function register(UserDTO $data): User
    {
        return User::create($data->toArray());
    }
}
