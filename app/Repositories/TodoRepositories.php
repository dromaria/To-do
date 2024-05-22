<?php

namespace App\Repositories;

use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
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

    public function update(int $id, UpdateTodoDTO $data): Todo|Model
    {
        $todo = Todo::findOrFail($id);
        $todo->update($data->toArray());
        return $todo;
    }

    public function destroy(int $id): Application|ResponseFactory|Response
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return response(status: 200);
    }
}
