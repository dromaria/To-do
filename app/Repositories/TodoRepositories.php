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
    public function index(PaginationDTO $paginationDTO, int $userId): Collection
    {
        $offset = ($paginationDTO->page - 1) * $paginationDTO->limit;
        return Todo::offset($offset)->limit($paginationDTO->limit)->where('user_id', $userId)->get();
    }

    public function store(StoreTodoDTO $data): Todo
    {
        return Todo::create($data->toArray());
    }

    public function show(int $id): Todo
    {
        return Todo::findOrFail($id);
    }

    public function update(int $id, UpdateTodoDTO $data): Todo
    {
        $todo = Todo::findOrFail($id);
        $todo->update($data->toArray());
        return $todo;
    }

    public function destroy(int $id): void
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
    }
}
