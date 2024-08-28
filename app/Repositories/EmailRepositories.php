<?php

namespace App\Repositories;

use App\DTO\User\VerifyUserDTO;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class EmailRepositories implements EmailRepositoryInterface
{
    public function storeCode(VerifyUserDTO $data): void
    {
        Cache::put('users:' . $data->user->id, $data->code, 60*60);
    }

    public function getCode(VerifyUserDTO $data): ?int
    {
        return Cache::get('users:' . $data->user->id);
    }

    public function verifyCode(VerifyUserDTO $data, int $code): void
    {
        if ($data->code == $code) {
            $data->user->forceFill(['email_verified_at' => now()])->save();
        }
    }
}
