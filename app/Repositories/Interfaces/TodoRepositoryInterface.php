<?php

namespace App\Repositories\Interfaces;

use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TodoRepositoryInterface
{
    public function index(PaginationDTO $paginationDTO, int $userId): Collection;
    public function store(StoreTodoDTO $data): Model|Todo;
    public function show(int $id): Model|Todo;
    public function update(int $id, UpdateTodoDTO $data): Model|Todo;
    public function destroy(int $id);
}
