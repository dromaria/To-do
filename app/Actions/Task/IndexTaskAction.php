<?php

namespace App\Actions\Task;

use App\DTO\Pagination\PaginationDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class IndexTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(PaginationDTO $paginationDTO, int $todo_id): Collection
    {
        return $this->taskRepository->index($paginationDTO, $todo_id);
    }
}
