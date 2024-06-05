<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ShowTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(int $id): Model|Task
    {
        return $this->taskRepository->show($id);
    }
}
