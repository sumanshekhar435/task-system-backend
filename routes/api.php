<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

// Authentication Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Task Routes (protected by auth middleware)
Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'getAllUser']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
});

Route::middleware('auth:api')->post('/logout', [UserController::class, 'logout']);
