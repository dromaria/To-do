<?php

namespace App\Repositories\Interfaces;

use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

interface TodoRepositoryInterface
{
    public function index(PaginationDTO $paginationDTO): Collection|Todo;
    public function store(StoreTodoDTO $data): Model|Todo;
    public function update(int $id, UpdateTodoDTO $data): Model|Todo;
    public function destroy(int $id);
}
