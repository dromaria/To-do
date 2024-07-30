<?php

namespace App\Actions\Auth;

use App\DTO\User\RegisterUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class RegisterAction
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(RegisterUserDTO $data): void
    {
        $this->userRepository->register($data);
    }
}
