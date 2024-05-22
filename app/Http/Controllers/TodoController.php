<?php

namespace App\Http\Controllers;

use App\Actions\Todo\DestroyTodoAction;
use App\Actions\Todo\IndexTodoAction;
use App\Actions\Todo\StoreTodoAction;
use App\Actions\Todo\UpdateTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function index(
        PaginationRequest $request,
        IndexTodoAction $indexTodoAction,
    ): ResourceCollection|TodoResource {
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

    public function show(Todo $todo): TodoResource
    {
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
        return $destroyTodoAction->execute($id);
    }
}
