<?php

namespace App\Http\Requests\Pagination;

use App\Http\Requests\Authorize\AuthorizeRequest;

class PaginationRequest extends AuthorizeRequest
{
    public function rules(): array
    {
        return [
            'limit'=>['integer', 'gt:0'],
            'page'=>['integer', 'gt:0'],
        ];
    }

    public function getLimit(): int
    {
        return $this->validated('limit') ?? 10;
    }

    public function getOffset(): int
    {
        return $this->validated('page') ?? 1;
    }
}
