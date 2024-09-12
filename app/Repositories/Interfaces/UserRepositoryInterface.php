<?php

namespace App\Repositories\Interfaces;

use App\DTO\User\RegisterUserDTO;
use App\DTO\User\UserDTO;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface UserRepositoryInterface
{
    public function register(RegisterUserDTO $data): void;
    public function attempt(UserDTO $data): bool|string;
    public function me(): User|Authenticatable|null;
    public function refresh(): string;
    public function verifyEmail(User $user): void;
}
