@extends('layouts.sidebar')

@section('header', 'Prullenbak')

@section('content')
    <h2 class="text-xl font-bold mb-4">Prullenbak</h2>

    @if($tasks->count())
        @foreach($tasks as $task)
            <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded shadow">
                <div class="font-semibold">{{ $task->title }}</div>
                <div class="text-gray-500">{{ $task->description }}</div>
                <form action="{{ route('tasks.restore', $task->id) }}" method="POST" class="inline">
                    @csrf
                    <button class="text-green-600 underline ml-2" type="submit">Herstellen</button>
                </form>
            </div>
        @endforeach
    @else
        <p class="text-gray-500">Geen verwijderde taken.</p>
    @endif
@endsection
