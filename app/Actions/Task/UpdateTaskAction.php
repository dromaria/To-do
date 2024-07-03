<?php

namespace App\Actions\Task;

use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use App\Models\Todo;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UpdateTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(int $id, UpdateTaskDTO $data): Task
    {
        $todoWithUser = $this->taskRepository->findUserAndTask($id);

        if (auth()->user()->cannot('check', [Todo::class, $todoWithUser->getRelation('todo')->user_id])) {
            abort(403);
        }

        return $this->taskRepository->update($id, $data);
    }
}
