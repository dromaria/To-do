<?php

namespace App\Repositories\Interfaces;

use App\DTO\Pagination\PaginationDTO;
use App\DTO\Task\StoreTaskDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function index(PaginationDTO $paginationDTO, int $todo_id): Collection|Task;
    public function store(StoreTaskDTO $data): Model|Task;
    public function show(int $id): Model|Task;
    public function update(int $id, UpdateTaskDTO $data): Model|Task;
    public function destroy(int $id): void;
}
