<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class EmailRepositories implements EmailRepositoryInterface
{
    public function storeCode(User $user): string
    {
        $code = fake()->numerify('######');
        Cache::put('users:' . $user->id, $code, 60*60);

        return $code;
    }

    public function getCode(User $user): ?string
    {
        return Cache::get('users:' . $user->id);
    }

    /**
     * @throws ValidationException
     */
    public function verifyCode(User $user, string $referenceCode, string $code): void
    {
        if ($referenceCode == $code) {
            $user->forceFill(['email_verified_at' => now()])->save();
        } else {
            throw ValidationException::withMessages(['code' => 'Invalid code']);
        }
    }
}
