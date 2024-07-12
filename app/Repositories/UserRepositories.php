<?php

namespace App\Repositories;

use App\DTO\User\RegisterUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepositories implements UserRepositoryInterface
{
    public function register(RegisterUserDTO $data): void
    {
        $data->password = Hash::make($data->password);
        User::create($data->toArray());
    }
}
