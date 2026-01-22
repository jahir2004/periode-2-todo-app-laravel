<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // GET /api/tasks
    public function index()
    {
        return response()->json(Task::all());
    }

    // POST /api/tasks
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:todo,in_progress,done',
            'category_id' => 'required|exists:categories,id',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'user_id' => auth()->id() ?? 1,
        ]);

        return response()->json($task, 201);
    }

    // PUT /api/tasks/{id}
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|string|in:todo,in_progress,done',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $task->update($request->all());

        return response()->json($task);
    }

    // DELETE /api/tasks/{id}
    public function destroy($id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    // GET /api/tasks/done
    public function done()
    {
        $tasks = Task::where('status', 'done')
                     ->where('user_id', auth()->id())
                     ->get();

        return response()->json($tasks);
    }
}
