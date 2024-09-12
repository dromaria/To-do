<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Authorize\AuthorizeRequest;

class EmailVerifyUserRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'digits:6'],
        ];
    }

    public function getCode(): string
    {
        return $this->validated('code');
    }
}
