<?php

namespace App\Actions\Task;

use App\DTO\Task\StoreTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StoreTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(StoreTaskDTO $data): Model|Task
    {
        return $this->taskRepository->store($data);
    }
}
