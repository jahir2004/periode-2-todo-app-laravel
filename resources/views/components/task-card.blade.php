@props(['task'])

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 group">
    <!-- Card Header met Status Badge -->
    <div class="p-5">
        <div class="flex items-start justify-between mb-3">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200 truncate pr-2">
                {{ $task->title }}
            </h3>
            
            <!-- Status Badge -->
            @php
                $statusColors = [
                    'todo' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                    'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                    'done' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                ];
                $statusLabels = [
                    'todo' => 'To Do',
                    'in_progress' => 'In Progress',
                    'done' => 'Done',
                ];
            @endphp
            <span class="px-3 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $statusLabels[$task->status] ?? $task->status }}
            </span>
        </div>
        
        <!-- Description -->
        @if($task->description)
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                {{ $task->description }}
            </p>
        @endif
        
        <!-- Category -->
        @if($task->category)
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">
                    {{ $task->category->name ?? 'Geen categorie' }}
                </span>
            </div>
        @endif
    </div>
    
    <!-- Card Footer -->
    <div class="px-5 py-3 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ $task->created_at->format('d M Y') }}</span>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-2">
                @if(Route::has('tasks.edit'))
                    <a href="{{ route('tasks.edit', $task) }}" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200" title="Bewerken">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                @endif
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-200" title="Verwijderen">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
