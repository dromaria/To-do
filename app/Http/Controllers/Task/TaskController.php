<?php

namespace App\Http\Controllers\Task;

use App\Actions\Task\DestroyTaskAction;
use App\Actions\Task\IndexTaskAction;
use App\Actions\Task\ShowTaskAction;
use App\Actions\Task\StoreTaskAction;
use App\Actions\Task\UpdateTaskAction;
use App\Actions\Todo\ShowTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\DTO\Task\StoreTaskDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(
        PaginationRequest $request,
        IndexTaskAction $indexTaskAction,
        ShowTodoAction $showTodoAction,
        int $todo_id
    ): ResourceCollection {
        $data = new PaginationDTO(['limit' => $request->getLimit(), 'offset' => $request->getOffset()]);
        $tasks = $indexTaskAction->execute($data, $todo_id, $showTodoAction);
        return TaskResource::collection($tasks);
    }

    public function store(
        StoreTaskRequest $request,
        StoreTaskAction $storeTaskAction,
        ShowTodoAction $showTodoAction,
        int $todo_id
    ): TaskResource {
        $data = new StoreTaskDTO(['todo_id' => $todo_id, ...($request->validated())]);
        $task = $storeTaskAction->execute($data, $showTodoAction);
        return new TaskResource($task);
    }

    public function show(ShowTaskAction $showTaskAction, int $id): TaskResource
    {
        $task = $showTaskAction->execute($id);

        return new TaskResource($task);
    }

    public function update(
        UpdateTaskRequest $request,
        UpdateTaskAction $updateTaskAction,
        int $id
    ): TaskResource {
        $data = new UpdateTaskDTO($request->validated());
        $task = $updateTaskAction->execute($id, $data);
        return new TaskResource($task);
    }

    public function destroy(DestroyTaskAction $destroyTaskAction, int $id): Application|Response|ResponseFactory
    {
        $destroyTaskAction->execute($id);
        return response(status: 200);
    }
}
