<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtask;

class SubtaskController extends Controller
{
    public function show(Subtask $subtask)
    {
        return view('subtasks.show', compact('subtask'));
    }
}
