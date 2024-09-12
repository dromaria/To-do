<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerifyEmailAction
{
    public function __construct(
        private EmailRepositoryInterface $emailRepository,
        private UserRepositoryInterface $userRepository,
        private MeAction $meAction
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function execute(string $code): void
    {
        /** @var User $user */
        $user = $this->meAction->execute();

        if ($user->email_verified_at) {
            throw new HttpException(409, 'Email has already been verified.');
        }

        $referenceCode = $this->emailRepository->getCode($user->id);

        if (!$code) {
            throw new NotFoundHttpException('Data not found in cache');
        }

        if ($referenceCode == $code) {
            $this->userRepository->verifyEmail($user);
        } else {
            throw ValidationException::withMessages(['code' => 'Invalid code']);
        }
    }
}
