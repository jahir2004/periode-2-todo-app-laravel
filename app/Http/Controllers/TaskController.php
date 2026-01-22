<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // filepath: app/Http/Controllers/TaskController.php
    
    public function index(Request $request)
    {
        $categoryId = $request->get('category');
        $tasks = Task::query(); // Haal alle taken op

        if ($categoryId) {
            $tasks->where('category_id', $categoryId);
        }

        return view('tasks.index', [
            'tasks' => $tasks->get(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);

        auth()->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete(); //soft delete
        return redirect()->back()->with('success', 'Taak verwijderd!');
    }

    public function trash()
    {
        $tasks = Task::onlyTrashed()->where('user_id', auth()->id())->get(); // Haal alleen soft-deleted taken op
        return view('tasks.trash', compact('tasks'));
    }

    public function restore($id)
    {
        Task::withTrashed()->find($id)->restore();
        return redirect()->route('tasks.trash')->with('success', 'Taak hersteld!');
    }
    public function completed()
    {
        $tasks = Task::where('status', 'done')->get();
        return view('tasks.completed', ['tasks' => $tasks]);
    }
}
