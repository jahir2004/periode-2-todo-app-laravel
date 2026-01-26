@extends('layouts.sidebar')

@section('header', 'Taak Details')

@section('content')
    <h1 class="text-2xl font-bold">{{ $task->title }}</h1>
    <p class="text-gray-600">{{ $task->description }}</p>

    <h2 class="mt-6 text-xl font-semibold">Subtaken</h2>
    <ul class="mt-4">
        @foreach ($task->subtasks as $subtask)
            <li class="flex items-center justify-between">
                <span>{{ $subtask->title }}</span>
                <form action="{{ route('subtasks.toggle', $subtask) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-sm {{ $subtask->is_done ? 'text-green-600' : 'text-gray-600' }}">
                        {{ $subtask->is_done ? 'Done' : 'Not Done' }}
                    </button>
                </form>
            </li>
        @endforeach
    </ul>

    {{-- Nieuwe subtask toevoegen --}}
    <form action="{{ route('subtasks.store', $task) }}" method="POST" class="mt-6">
        @csrf
        <input type="text" name="title" placeholder="Nieuwe subtask" class="border p-2 rounded w-full">
        <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Toevoegen</button>
    </form>

    {{-- Voortgang --}}
    <h3 class="mt-6 text-lg font-semibold">Voortgang</h3>
    @php
        $total = $task->subtasks->count();
        $completed = $task->subtasks->where('is_done', true)->count();
        $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
    @endphp
    <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
        <div class="bg-green-500 h-4 rounded-full" style="width: {{ $percentage }}%;"></div>
    </div>
    <p class="text-sm text-gray-600 mt-2">{{ $percentage }}% voltooid</p>
@endsection