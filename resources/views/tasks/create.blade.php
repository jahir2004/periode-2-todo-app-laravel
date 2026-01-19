<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Nieuwe taak</h2>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Titel</label>
            <input type="text" name="title" class="border p-2 w-full rounded">
        </div>
        {{--beschrijving--}}
        <div class="mb-4">
            <label class="block font-semibold">Beschrijving</label>
            <textarea name="description" class="border p-2 w-full rounded"></textarea>
        </div>
        {{--categorie--}}
        <div class="mb-4">
            <label class="block font-semibold">Categorie</label>
            <select name="category_id" class="border p-2 w-full rounded">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        {{--status--}}
        <div class="mb-4">
            <label class="block font-semibold">Status</label>
            <select name="status" class="border p-2 w-full rounded">
                <option value="todo">To do</option>
                <option value="in_progress">In progress</option>
                <option value="done">Done</option>
            </select>
        </div>
        {{--status todo in progress done--}}
        <div class="mb-4">
            <label class="block font-semibold">Status</label>
            <select name="status" class="border p-2 w-full rounded">
                <option value="todo">To do</option>
                <option value="in_progress">In progress</option>
                <option value="done">Done</option>
            </select>
        </div>
        
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Opslaan
        </button>
    </form>
</x-app-layout>
