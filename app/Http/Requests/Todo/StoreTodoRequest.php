<?php

namespace App\Http\Requests\Todo;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
