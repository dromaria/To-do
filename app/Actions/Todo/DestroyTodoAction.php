<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class DestroyTodoAction
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function execute($todo): Model|Todo
    {
        return $this->todoRepository->destroy($todo);
    }
}