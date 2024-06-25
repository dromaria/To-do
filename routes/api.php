<?php

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Todo\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthUserController::class, 'login']);
    Route::post('logout', [AuthUserController::class, 'logout']);
    Route::post('refresh', [AuthUserController::class, 'refresh']);
    Route::post('me', [AuthUserController::class, 'me']);
    Route::post('register', [RegisterUserController::class, 'store']);
});


Route::apiResource('todos', TodoController::class);

Route::controller(TaskController::class)->group(function () {
    Route::get('todos/{id}/tasks', 'index');
    Route::post('todos/{id}/tasks', 'store');
    Route::get('todos/tasks/{id}', 'show');
    Route::patch('todos/tasks/{id}', 'update');
    Route::delete('todos/tasks/{id}', 'destroy');
});
