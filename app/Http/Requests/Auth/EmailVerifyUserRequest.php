<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Authorize\AuthorizeRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class EmailVerifyUserRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'int'],
        ];
    }

    public function getCode(): int
    {
        return $this->validated('code');
    }
}
