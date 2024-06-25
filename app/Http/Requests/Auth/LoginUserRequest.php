<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Authorize\AuthorizeRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class LoginUserRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ];
    }

    public function getEmail(): string
    {
        return $this->validated('email');
    }

    public function getPassword(): string
    {
        return $this->validated('password');
    }
}
