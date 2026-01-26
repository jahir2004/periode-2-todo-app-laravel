<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubtaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task routes
    Route::get('/tasks/trash', [TaskController::class, 'trash'])->name('tasks.trash');
    Route::post('/tasks/restore/{id}', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::get('/tasks/completed', [TaskController::class, 'completed'])->name('tasks.completed');
    Route::resource('tasks', TaskController::class);

    // Subtask routes
    Route::post('/tasks/{task}/subtasks', [TaskController::class, 'addSubtask'])->name('subtasks.store');
    Route::patch('/subtasks/{subtask}/toggle', [TaskController::class, 'toggleSubtask'])->name('subtasks.toggle');
    Route::get('/subtasks/{subtask}', [SubtaskController::class, 'show'])->name('subtasks.show');
});


require __DIR__.'/auth.php';
