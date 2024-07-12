<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\Todo;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ShowTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(int $id): Task
    {
        $todoWithUser = $this->taskRepository->findUserAndTask($id);

        if (Auth::user()->cannot('check', [Todo::class, $todoWithUser->getRelation('todo')->user_id])) {
            abort(403);
        }

        return $todoWithUser;
    }
}
