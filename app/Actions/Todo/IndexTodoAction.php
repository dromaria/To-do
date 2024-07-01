<?php

namespace App\Actions\Todo;

use App\DTO\Pagination\PaginationDTO;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Support\Collection;

class IndexTodoAction
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(PaginationDTO $paginationDTO): Collection
    {
        $userId = auth()->user()->getAuthIdentifier();
        return $this->todoRepository->index($paginationDTO, $userId);
    }
}
