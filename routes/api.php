<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Todo\TodoController;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('jwt.auth');
    Route::post('me', [AuthController::class, 'me'])->middleware('jwt.auth');
});

Route::apiResource('todos', TodoController::class)->middleware('jwt.auth');

Route::controller(TaskController::class)->middleware('jwt.auth')->group(function () {
    Route::get('todos/{id}/tasks', 'index');
    Route::post('todos/{id}/tasks', 'store');
    Route::get('todos/tasks/{id}', 'show');
    Route::patch('todos/tasks/{id}', 'update');
    Route::delete('todos/tasks/{id}', 'destroy');
});
