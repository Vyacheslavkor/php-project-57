<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::paginate();

        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $user = auth()->user();
        $task->creator()->associate($user);

        return view('task.create', ['task' => $task, 'users' => User::get(), 'taskStatuses' => TaskStatus::get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name'           => 'required',
                'description'    => 'nullable|string',
                'status_id'      => ['required', 'exists:task_statuses,id'],
                'assigned_to_id' => ['nullable', 'exists:users,id'],
            ],
            [
                'name.required' => 'Это обязательное поле',
            ]
        );

        $task = new Task();
        $task->fill($data);

        $task->creator()->associate(User::find(auth()->id()));

        if (!empty($data['assigned_to_id'])) {
            $task->assignee()->associate(User::find($data['assigned_to_id']));
        }

        $task->save();

        flash('Задача успешно создана')->success();

        return redirect()->route('tasks.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('task.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('task.edit', ['task' => $task, 'users' => User::get(), 'taskStatuses' => TaskStatus::get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name'           => 'required',
            'description'    => 'nullable',
            'status_id'      => ['required', 'exists:task_statuses,id'],
            'assigned_to_id' => ['nullable', 'exists:users,id'],
        ]);

        $data['created_by_id'] = auth()->id();

        $task->update($data);

        flash('Задача успешно обновлена.')->success();

        return redirect()->route('tasks.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        flash('Задача успешно удалена.');

        return redirect()->route('tasks.index');
    }
}
