<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerifyEmailAction
{
    public function __construct(private EmailRepositoryInterface $repository)
    {
    }

    public function execute(string $code, MeAction $meAction): void
    {
        /** @var User $user */
        $user = $meAction->execute();

        if ($user->email_verified_at) {
            throw new HttpException(409, 'Email has already been verified.');
        }

        $referenceCode = $this->repository->getCode($user);

        if (!$code) {
            throw new NotFoundHttpException('Data not found in cache');
        }

        $this->repository->verifyCode($user, $referenceCode, $code);
    }
}
