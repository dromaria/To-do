<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class DestroyTodoAction
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(int $id): void
    {
        $this->todoRepository->destroy($id);
    }
}
