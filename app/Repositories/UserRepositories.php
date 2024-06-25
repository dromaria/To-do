<?php

namespace App\Repositories;

use App\DTO\User\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepositories implements UserRepositoryInterface
{
    public function register(UserDTO $data): Model|User
    {
        return User::create($data->toArray());
    }
}
