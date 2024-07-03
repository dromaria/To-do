<?php

namespace App\Actions\Task;

use App\Actions\Todo\ShowTodoAction;
use App\DTO\Task\StoreTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StoreTaskAction
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function execute(StoreTaskDTO $data, ShowTodoAction $showTodoAction): Task
    {
        $showTodoAction->execute($data->todo_id);

        return $this->taskRepository->store($data);
    }
}
