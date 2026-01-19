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
    public function index()
    {
        //all caetegorieen ophalen
        $categories = Category::all();

        //basis query voor ingelogde gebruiker
        $tasks = auth()->user()->tasks()->getQuery();
        $request = request();
        // filter als er een category is gekozen
        if ($request->filled('category')) {
            $tasks->where('category_id', $request->category); 
            }
        // voer de query uit
        $tasks = $tasks->get();
        // stuur de taken en categorien naar de view
       return view('tasks.index', compact('tasks', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
