<?php

namespace App\Repositories\Interfaces;

use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TodoRepositoryInterface
{
    public function index(): Collection|Todo;
    public function store(StoreTodoDTO $data): Model|Todo;
    public function update(Todo $todo, UpdateTodoDTO $data): Model|Todo;
    public function destroy(Todo $todo): Model|Todo;
}
