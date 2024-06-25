<?php

namespace App\Actions\Auth;

use App\DTO\User\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RegisterAction
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(UserDTO $data): Model|User
    {
        return $this->userRepository->register($data);
    }
}
