<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Task Manager') }}
        </h2>
    </x-slot>

    @php
    // Laravel automatically loads Str, so just use it
    @endphp


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                + New Task
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Completed</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($tasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $task->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ Str::limit($task->description, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($task->completed)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Yes
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    No
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium space-x-2">
    <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900 text-sm px-2 py-1 inline-block">
        Edit
    </a>

    @if (!$task->completed)
        <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <button type="submit" class="text-green-600 hover:text-green-900 text-sm px-2 py-1 border border-green-600 rounded inline-block">
                Done
            </button>
        </form>
    @endif

    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-900 text-sm px-2 py-1 border border-red-600 rounded inline-block">
            Delete
        </button>
    </form>
</td>


                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No tasks found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="mt-4 px-6">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
