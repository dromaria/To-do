<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ShowTodoAction
{

    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(int $id): Todo
    {
        $todo = $this->todoRepository->show($id);

        if (auth()->user()->cannot('check', [Todo::class, $todo->user_id])) {
            abort(403);
        }

        return $todo;
    }
}
