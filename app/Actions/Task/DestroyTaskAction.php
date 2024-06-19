<?php

namespace App\Actions\Task;

use App\Repositories\Interfaces\TaskRepositoryInterface;

class DestroyTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(int $id): void
    {
        $this->taskRepository->destroy($id);
    }
}
