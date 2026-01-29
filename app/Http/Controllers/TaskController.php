<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\Category;
use App\Models\Subtask;
use App\Models\User;
use App\Notifications\TaskCreated;
use App\Notifications\NewTaskForAdmin;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query()->where('user_id', auth()->id());

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $tasks = $query->get();
        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:todo,in_progress,done',
        ]);
    
        $validated['user_id'] = auth()->id();
        $task = Task::create($validated);
        $user = auth()->user();
        
        // Verstuur notificatie naar de gebruiker
        $user->notify(new TaskCreated($task));
        
        // Verstuur notificatie naar alle admins (gebruikers met email admin@example.com)
        $admins = User::where('email', 'admin@example.com')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewTaskForAdmin($task, $user));
        }
    
        return redirect()->route('tasks.index')->with('success', 'Taak succesvol aangemaakt! Je ontvangt een bevestigingsmail.');
    }

    public function show(string $id)
    {
         // Haal de taak op uit de database
        $task = Task::findOrFail($id);

        // Laad de subtaken
        $task->load('subtasks');

        // Geef de taak door aan de view
        return view('tasks.show', compact('task'));
    }

    public function addSubtask(Request $request, Task $task)
    {
        $request->validate(['title' => 'required|string|max:255']);
        $task->subtasks()->create(['title' => $request->title]);
        return redirect()->route('tasks.show', $task)->with('success', 'Subtask toegevoegd!');
    }

    public function toggleSubtask(Subtask $subtask) 
    {
        $subtask->update(['is_done' => !$subtask->is_done]);
        return back()->with('success', 'Subtask bijgewerkt!');
    }

    public function edit(Task $task)
    {
        // Simpele check: is dit jouw taak?
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Dit is niet jouw taak');
        }
        
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        // Simpele check: is dit jouw taak?
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Dit is niet jouw taak');
        }
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:todo,in_progress,done',
        ]);
    
        $task->update($validated);
    
        return redirect()->route('tasks.index')->with('success', 'Taak bijgewerkt!');
    }

    public function destroy(Task $task)
    {
        // Simpele check: is dit jouw taak?
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Dit is niet jouw taak');
        }
        
        $task->delete(); // soft delete
        return redirect()->back()->with('success', 'Taak verwijderd!');
    }

    public function trash()
    {
        $tasks = Task::onlyTrashed()->where('user_id', auth()->id())->get();
        return view('tasks.trash', compact('tasks'));
    }

    public function restore(Task $task)
    {
        // Simpele check: is dit jouw taak?
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Dit is niet jouw taak');
        }
        
        $task->restore();
        return redirect()->route('tasks.trash')->with('success', 'Taak hersteld!');
    }

    public function completed()
    {
        $tasks = Task::where('status', 'done')->where('user_id', auth()->id())->get();
        return view('tasks.completed', ['tasks' => $tasks]);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
}
