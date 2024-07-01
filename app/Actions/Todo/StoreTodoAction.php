<?php

namespace App\Actions\Todo;

use App\DTO\Todo\StoreTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StoreTodoAction
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function execute(StoreTodoDTO $data): Todo
    {
        return $this->todoRepository->store($data);
    }
}
