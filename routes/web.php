<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('tasks', TaskController::class)->middleware('auth');
Route::get('/profile', function () { 
    $user = auth()->user(); 
    return view('profile', compact('user')); 
    })->middleware('auth');
    Route::get('/profile/edit', function () { 
        $user = auth()->user(); 
        return view('profile', compact('user')); 
        })->name('profile.edit')->middleware('auth');
        
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

require __DIR__.'/auth.php';
