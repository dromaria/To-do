<?php

namespace App\Http\Requests\Authorize;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
