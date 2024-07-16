<?php

namespace App\Actions\Task;

use App\Models\Todo;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DestroyTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(int $id): void
    {
        $taskWithUser = $this->taskRepository->findUserAndTask($id);

        if (Auth::user()->cannot('check', [Todo::class, $taskWithUser->todo->user_id])) {
            abort(403);
        }

        $this->taskRepository->destroy($id);
    }
}
