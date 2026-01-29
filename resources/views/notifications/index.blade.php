@extends('layouts.sidebar')

@section('header', 'Mijn Notificaties')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header met acties -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">📬 Notificaties</h1>
            <p class="text-gray-600 dark:text-gray-400">
                Je hebt {{ auth()->user()->unreadNotifications->count() }} ongelezen notificaties
            </p>
        </div>
        
        <div class="flex gap-2">
            @if(auth()->user()->unreadNotifications->count() > 0)
            <a href="{{ route('notifications.mark-all-read') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                ✓ Alle markeren als gelezen
            </a>
            @endif
            
            <a href="{{ route('notifications.unread') }}" 
               class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                👁️ Alleen ongelezen
            </a>
        </div>
    </div>

    <!-- Success message -->
    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    <!-- Notificaties lijst -->
    @if($notifications->count() > 0)
    <div class="space-y-3">
        @foreach($notifications as $notification)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border {{ $notification->read_at ? 'border-gray-200' : 'border-blue-200 bg-blue-50 dark:bg-blue-900/20' }} p-4">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <!-- Status indicator -->
                    <div class="flex items-center gap-2 mb-2">
                        @if($notification->read_at)
                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                        <span class="text-xs text-gray-500">Gelezen</span>
                        @else
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-blue-600 font-medium">Nieuw</span>
                        @endif
                        
                        <span class="text-xs text-gray-400">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Notificatie content -->
                    <div class="mb-2">
                        @if($notification->data['type'] === 'task_created')
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 text-sm">🎯</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $notification->data['message'] }}
                                </p>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $notification->data['task_status'])) }}
                                    @if($notification->data['task_description'])
                                    <br><strong>Beschrijving:</strong> {{ $notification->data['task_description'] }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @elseif($notification->data['type'] === 'new_task_for_admin')
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 text-sm">📋</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $notification->data['message'] }}
                                </p>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    <strong>Door:</strong> {{ $notification->data['user_name'] }} ({{ $notification->data['user_email'] }})
                                    <br><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $notification->data['task_status'])) }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Acties -->
                    <div class="flex gap-2 mt-3">
                        @if(isset($notification->data['action_url']))
                        <a href="{{ $notification->data['action_url'] }}" 
                           class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200 transition">
                            👁️ Bekijk Taak
                        </a>
                        @endif
                        
                        @if(!$notification->read_at)
                        <a href="{{ route('notifications.mark-read', $notification->id) }}" 
                           class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200 transition">
                            ✓ Markeer als gelezen
                        </a>
                        @endif
                    </div>
                </div>
                
                <!-- Timestamp -->
                <div class="text-xs text-gray-400 ml-4">
                    {{ $notification->created_at->format('d M H:i') }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginatie -->
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>

    @else
    <!-- Geen notificaties -->
    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg">
        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
            <span class="text-2xl">📭</span>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
            Geen notificaties gevonden
        </h3>
        <p class="text-gray-500 dark:text-gray-400 mb-4">
            Je hebt momenteel geen notificaties.
        </p>
        <a href="{{ route('tasks.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            🎯 Nieuwe Taak Aanmaken
        </a>
    </div>
    @endif

    <!-- Demo sectie -->
    <div class="mt-8 bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-lg p-6 border border-purple-200 dark:border-purple-700">
        <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-300 mb-3">
            🚀 Demo: Notificatiesysteem
        </h3>
        <p class="text-purple-700 dark:text-purple-400 mb-4">
            Dit notificatiesysteem toont zowel email als database notificaties. 
            Wanneer je een nieuwe taak aanmaakt, krijg je hier een notificatie én een email!
        </p>
        <div class="flex gap-2">
            <a href="{{ route('tasks.create') }}" 
               class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                ✨ Test het systeem
            </a>
            @if(app()->environment('local'))
            <a href="{{ route('test.notifications.page') }}" 
               class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
               🧪 Test Pagina
            </a>
            @endif
        </div>
    </div>
</div>
@endsection