<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\Authorize\AuthorizeRequest;

class UpdateTaskRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string'],
            'description' => ['string', 'nullable'],
            'is_active' => ['boolean'],
            'estimation' => ['date', 'nullable'],
        ];
    }
}
