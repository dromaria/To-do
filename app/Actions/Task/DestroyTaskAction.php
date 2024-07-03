<?php

namespace App\Actions\Task;

use App\Models\Todo;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class DestroyTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(int $id): void
    {
        $todoWithUser = $this->taskRepository->findUserAndTask($id);

        if (auth()->user()->cannot('check', [Todo::class, $todoWithUser->getRelation('todo')->user_id])) {
            abort(403);
        }

        $this->taskRepository->destroy($id);
    }
}
