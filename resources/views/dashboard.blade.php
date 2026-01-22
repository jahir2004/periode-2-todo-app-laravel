@extends('layouts.sidebar')

@section('header', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 mb-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Welkom terug, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-indigo-100">Hier is een overzicht van je taken voor vandaag.</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Todo Count -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">To Do</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $todoCount ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 dark:bg-yellow-900/50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-yellow-600 dark:text-yellow-400 font-medium">Wachtend</span>
                <span class="text-gray-400 mx-2">•</span>
                <span class="text-gray-500 dark:text-gray-400">nog te starten</span>
            </div>
        </div>

        <!-- In Progress Count -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">In Progress</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $inProgressCount ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-blue-600 dark:text-blue-400 font-medium">Actief</span>
                <span class="text-gray-400 mx-2">•</span>
                <span class="text-gray-500 dark:text-gray-400">momenteel bezig</span>
            </div>
        </div>

        <!-- Done Count -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Voltooid</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $doneCount ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 dark:bg-green-900/50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 dark:text-green-400 font-medium">Afgerond</span>
                <span class="text-gray-400 mx-2">•</span>
                <span class="text-gray-500 dark:text-gray-400">goed gedaan!</span>
            </div>
        </div>
    </div>

    <!-- Recent Tasks Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Recente Taken</h2>
            <a href="{{ route('tasks.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium transition-colors duration-200">
                Bekijk alles →
            </a>
        </div>
        
        @if(isset($recentTasks) && $recentTasks->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentTasks as $task)
                    <x-task-card :task="$task" />
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-xl p-12 text-center border border-gray-100 dark:border-gray-700">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Geen taken gevonden</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Begin met het maken van je eerste taak!</p>
                <a href="{{ route('tasks.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nieuwe Taak
                </a>
            </div>
        @endif
    </div>

    <!-- Quick Stats Footer -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-6">
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ ($todoCount ?? 0) + ($inProgressCount ?? 0) + ($doneCount ?? 0) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Totaal Taken</p>
                </div>
                <div class="w-px h-10 bg-gray-200 dark:bg-gray-700"></div>
                <div class="text-center">
                    @php
                        $total = ($todoCount ?? 0) + ($inProgressCount ?? 0) + ($doneCount ?? 0);
                        $percentage = $total > 0 ? round(($doneCount ?? 0) / $total * 100) : 0;
                    @endphp
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $percentage }}%</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Voltooid</p>
                </div>
            </div>
            <div class="flex-1 max-w-md">
                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                    <span>Voortgang</span>
                    <span>{{ $percentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
