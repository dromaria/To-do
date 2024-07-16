<?php

namespace App\Actions\Todo;

use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UpdateTodoAction
{

    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(int $id, UpdateTodoDTO $data): Model|Todo
    {
        /** @var Todo $todo */
        $todo = $this->todoRepository->show($id);

        if (Auth::user()->cannot('check', [Todo::class, $todo->user_id])) {
            abort(403);
        }

        return $this->todoRepository->update($id, $data);
    }
}
