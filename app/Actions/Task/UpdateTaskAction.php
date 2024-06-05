<?php

namespace App\Actions\Task;

use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UpdateTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(int $id, UpdateTaskDTO $data): Model|Task
    {
        return $this->taskRepository->update($id, $data);
    }
}
