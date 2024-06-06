<?php

use App\Http\Controllers\TaskController\TaskController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('todos', TodoController::class);

Route::controller(TaskController::class)->group(function () {
    Route::get('todos/{id}/tasks', 'index');
    Route::post('todos/{id}/tasks', 'store');
    Route::get('todos/tasks/{id}', 'show');
    Route::patch('todos/tasks/{id}', 'update');
    Route::delete('todos/tasks/{id}', 'destroy');
});
