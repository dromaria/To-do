<?php

namespace App\Actions\Auth;

use App\DTO\User\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class RegisterAction
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(UserDTO $data): User
    {
        return $this->userRepository->register($data);
    }
}
