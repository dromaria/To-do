<?php

namespace App\Actions\Todo;

use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UpdateTodoAction
{

    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(Todo $todo, UpdateTodoDTO $data): Model|Todo
    {
        return $this->todoRepository->update($todo, $data);
    }
}
