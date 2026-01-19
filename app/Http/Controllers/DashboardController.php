<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Tel de taken per status voor de huidige gebruiker
        $todoCount = auth()->user()->tasks()->where('status', 'todo')->count();
        $inProgressCount = auth()->user()->tasks()->where('status', 'in_progress')->count();
        $doneCount = auth()->user()->tasks()->where('status', 'done')->count();

        return view('dashboard', compact('todoCount', 'inProgressCount', 'doneCount'));
    }
}