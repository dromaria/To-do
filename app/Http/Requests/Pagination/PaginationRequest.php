<?php

namespace App\Http\Requests\Pagination;

use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'limit'=>'int',
            'offset'=>'int',
        ];
    }

    public function getLimit(): int
    {
        return $this->validated('limit') ?? 10;
    }

    public function getOffset(): int
    {
        return $this->validated('offset') ?? 1;
    }
}
