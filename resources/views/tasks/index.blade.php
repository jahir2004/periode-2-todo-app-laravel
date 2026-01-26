@extends('layouts.sidebar')

@section('header', 'Mijn taken')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Mijn taken</h1>

        {{-- Filter dropdown --}}
        <div class="mb-6">
            <form method="GET" action="{{ route('tasks.index') }}">
                <select name="category" onchange="this.form.submit()" class="p-2 border rounded">
                    <option value="">Alle categorieën</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Takenlijst --}}
        @if ($tasks && $tasks->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($tasks as $task)
                    <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                        {{-- Klikbare titel --}}
                        <h2 class="text-lg font-bold text-blue-600 hover:underline">
                            {{ $task->title }}
                        </h2>
                        <p class="text-gray-600 mt-2">{{ $task->description }}</p>
                        <p class="text-sm text-gray-500 mt-2">Status: {{ $task->status }}</p>

                        {{-- Acties --}}
                        <div class="flex items-center justify-between mt-4">
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Verwijderen</button>
                            </form>
                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:underline">Bewerken</a>
                            <a href="{{ route('tasks.show', $task) }}" class="text-green-600 hover:underline">Subtaken</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Geen taken gevonden voor deze categorie.</p>
        @endif
    </div>
@endsection