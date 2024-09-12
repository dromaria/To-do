<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class EmailRepositories implements EmailRepositoryInterface
{
    private const CODE_TTL = 3600;
    public function storeCode(int $userID): string
    {
        $code = fake()->numerify('######');
        Cache::put($this->generateKey($userID), $code, self::CODE_TTL);

        return $code;
    }

    public function getCode(int $userID): ?string
    {
        return Cache::get($this->generateKey($userID));
    }

    private function generateKey(int $userID): string
    {
        return 'users:' . $userID;
    }
}
