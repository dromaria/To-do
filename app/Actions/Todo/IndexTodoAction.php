<?php

namespace App\Actions\Todo;

use App\DTO\Pagination\PaginationDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class IndexTodoAction
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(PaginationDTO $paginationDTO): LengthAwarePaginator|Todo
    {
        return $this->todoRepository->index($paginationDTO);
    }
}
