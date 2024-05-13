<?php

namespace App\Repositories;

use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TodoRepositories implements TodoRepositoryInterface
{
    public function index(PaginationDTO $paginationDTO): Collection|Todo
    {
        $offset = ($paginationDTO->page - 1) * $paginationDTO->limit;
        return Todo::offset($offset)->limit($paginationDTO->limit)->get();
    }

    public function store(StoreTodoDTO $data): Model|Todo
    {
        return Todo::create($data->toArray());
    }

    public function update(Todo $todo, UpdateTodoDTO $data): Model|Todo
    {
        $todo->update($data->toArray());
        return $todo;
    }
    public function destroy(Todo $todo): Model|Todo
    {
        $todo->delete();
        return $todo;
    }
}
