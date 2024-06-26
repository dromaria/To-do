<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\Authorize\AuthorizeRequest;

class StoreTaskRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'is_active' => ['boolean'],
            'estimation' => ['date', 'nullable'],
        ];
    }
}
