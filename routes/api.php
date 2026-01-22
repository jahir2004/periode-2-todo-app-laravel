<?php

use App\Http\Controllers\Api\TaskController;

// API routes
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/done', [TaskController::class, 'done']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);