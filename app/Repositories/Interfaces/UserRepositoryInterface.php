<?php

namespace App\Repositories\Interfaces;

use App\DTO\User\UserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function register(UserDTO $data): Model|User;
}
