<?php

namespace App\Repositories;

use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TodoRepositories implements TodoRepositoryInterface
{
    public function index(): Collection|Todo
    {
        return Todo::all();
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
