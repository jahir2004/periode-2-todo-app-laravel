<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Mijn profiel
        </h2>
    </x-slot>

    <div class="p-6">
        <p><strong>Naam:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Aantal taken:</strong> {{ $user->tasks()->count() }}</p>
    </div>
</x-app-layout>
