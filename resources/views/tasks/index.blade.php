<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Mijn taken</h2>
    </x-slot>

    <div class="p-6">
        @forelse($tasks as $task)
            <div class="mb-4 p-4 bg-white shadow rounded">
                <h3 class="font-bold">{{ $task->title }}</h3>
                <p>{{ $task->description }}</p>
            </div>
        @empty
            <p>Je hebt nog geen taken.</p>
        @endforelse
    </div>
</x-app-layout>