<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Show list of tasks belonging to the logged-in user
    public function index()
    {
        // Get tasks only for authenticated user, latest first, paginate 10 per page
        $tasks = Task::where('user_id', auth()->id())
                     ->latest()
                     ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    // Show form to create task
    public function create()
    {
        return view('tasks.create');
    }

    // Store new task associated with logged-in user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
        ]);

        // Convert checkbox input to boolean
        $validated['completed'] = $request->has('completed');

        // Associate task with authenticated user
        $validated['user_id'] = auth()->id();

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    // Show form to edit a task
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
        ]);

        $validated['completed'] = $request->has('completed');

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    // Delete task
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function markComplete(Task $task)
{
    // Optional: Check that the user owns this task
    if ($task->user_id !== auth()->id()) {
        abort(403); // Forbidden
    }

    $task->update(['completed' => true]);

    return redirect()->route('tasks.index')->with('success', 'Task marked as complete.');
}

}
