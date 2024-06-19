<?php

namespace App\Actions\Task;

use App\DTO\Task\StoreTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StoreTaskAction
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TodoRepositoryInterface $todoRepository
    ) {
    }

    public function execute(StoreTaskDTO $data): Model|Task
    {
        $this->todoRepository->show($data->todo_id);
        return $this->taskRepository->store($data);
    }
}
