<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function index()
    {
        return Inertia::render('tasks/Index', [
            'tasks' => Task::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('tasks/Create');
    }

    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        return to_route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return Inertia::render('tasks/Edit', [
            'task' => $task,
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return to_route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully.');
    }
}
