<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Mijn taken</h2>
    </x-slot>

    {{-- filter dropdown --}}
    <form method="GET" class="mb-4">
        <select name="category" onchange="this.form.submit()" class="border p-2 rounded">
            <option value="">Alle categorieën</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- custom pijl rechts --}}
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.354a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </div>
</div>
            

    {{-- takenlijst --}}
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