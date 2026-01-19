<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Mijn taken</h2>
    </x-slot>

    {{-- filter dropdown --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('tasks.index') }}">
            <select name="category" onchange="this.form.submit()" class="px-4 py-2 border rounded">
                <option value="">Alle categorieën</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- takenlijst --}}
    <div class="p-6">
        @if ($tasks && $tasks->count())
            @foreach ($tasks as $task)
                <div class="mb-4 p-4 bg-white shadow rounded">
                    <h3 class="font-bold">{{ $task->title }}</h3>
                    <p>{{ $task->description }}</p>

                    {{-- Verwijderknop --}}
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Verwijderen</button>
                    </form>
                </div>
            @endforeach
        @else
            <p>Geen taken gevonden voor deze categorie.</p>
        @endif
    </div>
</x-app-layout>