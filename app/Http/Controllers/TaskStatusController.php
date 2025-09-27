<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = TaskStatus::paginate();

        return view('task_status.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task_status.create', ['taskStatus' => new TaskStatus()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(
            [
                'name' => 'required|unique:task_statuses',
            ],
            [
                'name.required' => 'Это обязательное поле',
                'name.unique'   => 'Статус с таким именем уже существует',
            ]
        );

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data)->save();

        flash('Статус успешно создан')->success();

        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus): RedirectResponse
    {
        return redirect()->route('task_statuses.edit', $taskStatus);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($taskStatusId)
    {
        return view('task_status.edit', ['taskStatus' => TaskStatus::findOrFail($taskStatusId)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $request->validate(
            [
                'name' => "required|unique:task_statuses,name,$taskStatus->id",
            ],
            [
                'name.required' => 'Это обязательное поле',
                'name.unique'   => 'Статус с таким именем уже существует',
            ]
        );

        $taskStatus->fill($data);
        $taskStatus->save();

        flash('Статус успешно изменён')->success();

        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        if ($taskStatus->tasks()->exists()) {
            flash('Не удалось удалить статус')->error();

            return redirect()->route('task_statuses.index', ['error' => 'used_in_tasks']);
        }

        $taskStatus->delete();

        flash('Статус успешно удалён')->success();

        return redirect()->route('task_statuses.index')->with('success');
    }
}
