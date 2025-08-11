<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
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
    $statuses = collect(TaskStatus::cases())
        ->map(fn($c) => ['value' => $c->value, 'label' => ucfirst($c->value)])
        ->all();

    return Inertia::render('tasks/Create', [
        'statuses' => $statuses,
    ]);
}

public function store(TaskRequest $request)
{
    $data = $request->validated();
    $data['user_id'] = auth()->id();

    $task = Task::create($data);

    return redirect()->route('tasks.index')
        ->with('success', 'Task criada com sucesso!');
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

    public function move(Task $task)
{
    request()->validate(['status' => 'required|in:todo,doing,done']);
    $task->update(['status' => request('status')]);

    // Se estiver em página Inertia, use back com flash;
    // via API, retorne JSON:
    if (request()->wantsJson()) {
        return response()->json(['message' => 'Status atualizado', 'task' => $task], 200);
    }
    return back();
}

}
