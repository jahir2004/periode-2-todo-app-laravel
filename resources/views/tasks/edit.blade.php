
{{-- filepath: resources/views/tasks/edit.blade.php --}}
@extends('layouts.sidebar')

@section('header', 'Taak bewerken')

@section('content')
    <h2 class="text-xl font-bold mb-4">Taak bewerken</h2>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="max-w-2xl">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-2">Titel</label>
            <input type="text" name="title" value="{{ $task->title }}" class="border p-2 w-full rounded" required>
            @error('title')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Beschrijving</label>
            <textarea name="description" class="border p-2 w-full rounded">{{ $task->description }}</textarea>
            @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Categorie</label>
            <select name="category_id" class="border p-2 w-full rounded">
                <option value="">Geen categorie</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($task->category_id == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Status</label>
            <select name="status" class="border p-2 w-full rounded" required>
                <option value="todo" @if($task->status == 'todo') selected @endif>To Do</option>
                <option value="in_progress" @if($task->status == 'in_progress') selected @endif>In Progress</option>
                <option value="done" @if($task->status == 'done') selected @endif>Done</option>
            </select>
            @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Opslaan
            </button>
            <a href="{{ route('tasks.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                Annuleren
            </a>
        </div>
    </form>
@endsection