<?php

namespace App\Actions\Auth;

use App\DTO\User\UserDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginAction
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(UserDTO $data): bool|string
    {
        $token = $this->repository->attempt($data);

        if (!$token) {
            throw new UnauthorizedHttpException('Bearer', 'Invalid credentials');
        }

        return $token;
    }
}
