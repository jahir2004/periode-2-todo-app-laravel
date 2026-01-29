<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\NotificationController;
use App\Models\User;
use App\Models\Task;
use App\Notifications\TaskCreated;

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
    
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    
    // Test route voor notificaties (alleen in development)
    if (app()->environment('local')) {
        Route::get('/test-notifications', function () {
            return view('test-notifications');
        })->name('test.notifications.page');
        
        Route::get('/test-notification', function () {
            $user = auth()->user();
            $testTask = new Task([
                'title' => 'Test Taak voor Notificatie',
                'description' => 'Dit is een test taak om de email notificatie te testen.',
                'status' => 'todo',
                'user_id' => $user->id
            ]);
            
            $user->notify(new TaskCreated($testTask));
            
            return redirect()->route('test.notifications.page')
                ->with('success', 'Test notificatie verstuurd! Check je logs in storage/logs/laravel.log');
        })->name('test.notification');
    }
});


require __DIR__.'/auth.php';
