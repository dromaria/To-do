<?php

namespace App\Actions\Task;

use App\Actions\Todo\ShowTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class IndexTaskAction
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function execute(PaginationDTO $paginationDTO, int $todo_id, ShowTodoAction $showTodoAction): Collection
    {
        $showTodoAction->execute($todo_id);

        return $this->taskRepository->index($paginationDTO, $todo_id);
    }
}
