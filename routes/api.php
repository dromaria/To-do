<?php

use App\Http\Controllers\AuthController;
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

    //Route::post('login', 'AuthController@login');
    Route::post('login', [AuthController::class, 'login']);
    //Route::post('logout', 'AuthController@logout');
    Route::post('logout', [AuthController::class, 'logout']);
    //Route::post('refresh', 'AuthController@refresh');
    Route::post('refresh', [AuthController::class, 'refresh']);
    //Route::post('me', 'AuthController@me');
    Route::post('me', [AuthController::class, 'me']);
});


Route::apiResource('todos', TodoController::class);

Route::controller(TaskController::class)->group(function () {
    Route::get('todos/{id}/tasks', 'index');
    Route::post('todos/{id}/tasks', 'store');
    Route::get('todos/tasks/{id}', 'show');
    Route::patch('todos/tasks/{id}', 'update');
    Route::delete('todos/tasks/{id}', 'destroy');
});
