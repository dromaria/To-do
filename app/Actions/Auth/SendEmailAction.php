<?php

namespace App\Actions\Auth;

use App\Jobs\SendEmailCode;
use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;

class SendEmailAction
{
    public function __construct(private EmailRepositoryInterface $repository)
    {
    }

    public function execute(MeAction $meAction): void
    {
        /** @var User $user */
        $user = $meAction->execute();

        $code = $this->repository->storeCode($user);

        SendEmailCode::dispatchIf(!$user->email_verified_at, $user, $code);
    }
}
