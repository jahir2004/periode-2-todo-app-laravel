@extends('layouts.app')

@section('content')
    <div style="padding: 20px;">
        <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Mijn taken</h1>

        {{-- filter dropdown --}}
        <div style="margin-bottom: 20px;">
            <form method="GET" action="{{ route('tasks.index') }}">
                <select name="category" onchange="this.form.submit()" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">Alle categorieën</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- takenlijst --}}
        @if ($tasks && $tasks->count())
            @foreach ($tasks as $task)
                <div style="margin-bottom: 20px; padding: 15px; background: white; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h3 style="font-weight: bold; color: black; margin-bottom: 10px;">{{ $task->title }}</h3>
                    <p style="color: #666; margin-bottom: 10px;">{{ $task->description }}</p>
                    <p style="color: #999; font-size: 12px; margin-bottom: 10px;">Status: {{ $task->status }}</p>

                    {{-- Verwijderknop --}}
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red; text-decoration: underline; cursor: pointer; background: none; border: none;">Verwijderen</button>
                    </form>
                </div>
            @endforeach
        @else
            <p style="color: #666;">Geen taken gevonden voor deze categorie.</p>
        @endif
    </div>
@endsection