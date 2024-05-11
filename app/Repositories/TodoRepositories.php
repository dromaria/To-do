<?php

namespace App\Repositories;

use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class TodoRepositories implements TodoRepositoryInterface
{
    public function index(PaginationDTO $paginationDTO): LengthAwarePaginator|Todo
    {
        return Todo::paginate($paginationDTO->limit, ['*'], 'page', $paginationDTO->offset);
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
