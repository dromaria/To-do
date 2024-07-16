<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShowTodoAction
{

    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(int $id): Model|Todo
    {
        /** @var Todo $todo */
        $todo = $this->todoRepository->show($id);

        if (Auth::user()->cannot('check', [Todo::class, $todo->user_id])) {
            abort(403);
        }

        return $todo;
    }
}
