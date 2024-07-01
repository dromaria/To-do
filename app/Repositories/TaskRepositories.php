<?php

namespace App\Repositories;

use App\DTO\Pagination\PaginationDTO;
use App\DTO\Task\StoreTaskDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TaskRepositories implements TaskRepositoryInterface
{
    public function index(PaginationDTO $paginationDTO, int $todo_id): Collection
    {
        $offset = ($paginationDTO->page - 1) * $paginationDTO->limit;
        return Task::where('todo_id', $todo_id)->offset($offset)->limit($paginationDTO->limit)->get();
    }

    public function store(StoreTaskDTO $data): Task
    {
        return Task::create($data->toArray());
    }

    public function show(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function update(int $id, UpdateTaskDTO $data): Task
    {
        $task = Task::findOrFail($id);
        $task->update($data->toArray());
        return $task;
    }
    public function destroy(int $id): void
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }

    public function findUserAndTask(int $id): Task
    {
        return Task::where('id', $id)->with('todo:id,user_id')->firstOrFail();
    }
}
