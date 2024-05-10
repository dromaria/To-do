<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class DestroyTodoAction
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(Todo $todo): Model|Todo
    {
        return $this->todoRepository->destroy($todo);
    }
}
