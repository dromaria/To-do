<?php

namespace App\Actions\Auth;

use App\DTO\User\VerifyUserDTO;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerifyEmailAction
{
    public function __construct(private EmailRepositoryInterface $repository)
    {
    }

    public function execute(VerifyUserDTO $data): void
    {
        $code = $this->repository->getCode($data);

        if (!$code) {
            throw new NotFoundHttpException('Data not found in cache');
        }

        $this->repository->verifyCode($data, $code);
    }
}
