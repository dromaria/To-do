<?php

namespace App\Http\Controllers\Todo;

use App\Actions\Todo\DestroyTodoAction;
use App\Actions\Todo\IndexTodoAction;
use App\Actions\Todo\ShowTodoAction;
use App\Actions\Todo\StoreTodoAction;
use App\Actions\Todo\UpdateTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function index(
        PaginationRequest $request,
        IndexTodoAction $indexTodoAction,
    ): ResourceCollection {
        $data = new PaginationDTO(['limit' => $request->getLimit(), 'offset' => $request->getOffset()]);
        $todos = $indexTodoAction->execute($data);
        return TodoResource::collection($todos);
    }

    public function store(StoreTodoRequest $request, StoreTodoAction $storeTodoAction): TodoResource
    {
        $data = new StoreTodoDTO(['title' => $request->getTitle(), 'description' => $request->getDescription()]);
        $todo = $storeTodoAction->execute($data);

        return new TodoResource($todo);
    }

    public function show(int $id, ShowTodoAction $showTodoAction): TodoResource
    {
        $todo = $showTodoAction->execute($id);
        return new TodoResource($todo);
    }

    public function update(UpdateTodoRequest $request, int $id, UpdateTodoAction $updateTodoAction): TodoResource
    {
        $data = new UpdateTodoDTO($request->validated());
        $todo = $updateTodoAction->execute($id, $data);
        return new TodoResource($todo);
    }

    public function destroy(int $id, DestroyTodoAction $destroyTodoAction): Application|ResponseFactory|Response
    {
        $destroyTodoAction->execute($id);
        return response(status:200);
    }
}
