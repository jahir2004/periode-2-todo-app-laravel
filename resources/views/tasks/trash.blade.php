<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Prullenbak</h2>
    </x-slot>

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Verwijderde Taken</h1>

        @if ($tasks->count())
            @foreach ($tasks as $task)
                <div class="mb-4 p-4 bg-white shadow rounded">
                    <h3 class="font-bold">{{ $task->title }}</h3>
                    <p>{{ $task->description }}</p>
                    <p class="text-sm text-gray-500">Verwijderd op: {{ $task->deleted_at->format('d-m-Y H:i') }}</p>

                    {{-- Herstelknop --}}
                    <form action="{{ route('tasks.restore', $task->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="text-green-500 hover:underline">Herstellen</button>
                    </form>
                </div>
            @endforeach
        @else
            <div class="p-4 bg-gray-100 rounded">
                <p class="text-gray-700">Geen verwijderde taken gevonden.</p>
            </div>
        @endif
    </div>
</x-app-layout>
