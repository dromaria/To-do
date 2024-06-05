<?php

namespace App\Http\Requests\Todo;

use App\Http\Requests\Authorize\AuthorizeRequest;

class StoreTodoRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'title'=>['required', 'string'],
            'description'=>['string', 'nullable'],
        ];
    }

    public function getTitle(): string
    {
        return $this->validated('title');
    }

    public function getDescription(): ?string
    {
        return $this->validated('description');
    }
}
