<?php

namespace App\Repositories;

use App\DTO\User\RegisterUserDTO;
use App\DTO\User\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserRepositories implements UserRepositoryInterface
{
    public function register(RegisterUserDTO $data): void
    {
        $data->password = Hash::make($data->password);
        User::create($data->toArray());
    }

    public function attempt(UserDTO $data): bool|string
    {
        return Auth::attempt($data->toArray());
    }

    public function me(): User|Authenticatable|null
    {
        return Auth::user();
    }

    public function refresh(): string
    {
        return Auth::refresh(true);
    }
}
