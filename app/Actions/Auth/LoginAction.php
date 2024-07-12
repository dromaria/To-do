<?php

namespace App\Actions\Auth;

use App\DTO\User\UserDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginAction
{
    public function execute(UserDTO $data): JsonResponse|array
    {
        if (! $token = Auth::attempt($data->toArray())) {
            throw new UnauthorizedHttpException('Bearer', 'Invalid credentials');
        }

        return AuthHelpers::respondWithToken($token);
    }
}
