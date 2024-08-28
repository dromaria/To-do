<?php

namespace App\Actions\Auth;

use App\DTO\User\VerifyUserDTO;
use App\Jobs\SendEmailCode;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class SendEmailAction
{
    public function __construct(private EmailRepositoryInterface $repository)
    {
    }

    public function execute(): void
    {
        $data = new VerifyUserDTO([
            'user' => Auth::user(),
            'code' => fake()->numerify('######'),
        ]);

        $this->repository->storeCode($data);

        SendEmailCode::dispatchIf(!$data->user->email_verified_at, $data);
    }
}
