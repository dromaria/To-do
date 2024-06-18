<?php

namespace App\Actions\Task;

use App\DTO\Pagination\PaginationDTO;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Support\Collection;

class IndexTaskAction
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TodoRepositoryInterface $todoRepository
    ) {
    }

    public function execute(PaginationDTO $paginationDTO, int $todo_id): Collection
    {
        $this->todoRepository->show($todo_id);
        return $this->taskRepository->index($paginationDTO, $todo_id);
    }
}
