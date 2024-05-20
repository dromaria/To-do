<?php

namespace App\Http\Requests\Todo;

use App\Http\Requests\Authorize\AuthorizeRequest;

class UpdateTodoRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'title'=>['string'],
            'description'=>['string', 'nullable'],
        ];
    }
}
