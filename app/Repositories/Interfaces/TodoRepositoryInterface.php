<?php

namespace App\Repositories\Interfaces;

use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface TodoRepositoryInterface
{
    public function index(PaginationDTO $paginationDTO): LengthAwarePaginator|Todo;
    public function store(StoreTodoDTO $data): Model|Todo;
    public function update(Todo $todo, UpdateTodoDTO $data): Model|Todo;
    public function destroy(Todo $todo): Model|Todo;
}
