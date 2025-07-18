<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $task->title) }}" required
                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 flex items-center space-x-3">
                    <input id="completed" name="completed" type="checkbox" {{ $task->completed ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 focus:ring-blue-500" />
                    <label for="completed" class="text-gray-700 dark:text-gray-300">Donee</label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-700 dark:text-gray-900">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-green-600 rounded text-white hover:bg-green-700">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
