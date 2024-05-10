<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class IndexTodoAction
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(): Collection|Todo
    {
        return $this->todoRepository->index();
    }
}
