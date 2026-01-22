<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Tel de taken per status voor de ingelogde gebruiker
        $userId = Auth::id();
        
        $todoCount = Task::where('user_id', $userId)->where('status', 'todo')->count();
        $inProgressCount = Task::where('user_id', $userId)->where('status', 'in_progress')->count();
        $doneCount = Task::where('user_id', $userId)->where('status', 'done')->count();
        
        // Haal recente taken op met category relatie
        $recentTasks = Task::with('category')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('dashboard', compact('todoCount', 'inProgressCount', 'doneCount', 'recentTasks'));
    }
}