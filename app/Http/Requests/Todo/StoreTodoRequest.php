<?php

namespace App\Http\Requests\Todo;

use App\Http\Requests\Authorize\AuthorizeRequest;

class StoreTodoRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'title'=>['required', 'string'],
            'description'=>['string'],
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
