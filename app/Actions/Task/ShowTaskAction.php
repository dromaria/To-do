<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\Todo;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShowTaskAction
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(int $id): Model|Task
    {
        $taskWithUser = $this->taskRepository->findUserAndTask($id);

        if (Auth::user()->cannot('check', [Todo::class, $taskWithUser->todo->user_id])) {
            abort(403);
        }

        return $taskWithUser;
    }
}
