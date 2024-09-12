<?php

namespace App\Actions\Auth;

use App\Jobs\SendEmailCode;
use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;

class SendEmailAction
{
    public function __construct(private EmailRepositoryInterface $repository, private MeAction $meAction)
    {
    }

    public function execute(): void
    {
        /** @var User $user */
        $user = $this->meAction->execute();

        $code = $this->repository->storeCode($user->id);

        SendEmailCode::dispatchIf(!$user->email_verified_at, $user, $code);
    }
}
