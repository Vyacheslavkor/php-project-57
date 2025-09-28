<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
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
        return view('label.index', ['labels' => Label::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('label.create', ['label' => new Label()]);
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
            ],
            [
                'name.required' => 'Это обязательное поле',
            ]
        );

        $label = new Label();
        $label->fill($data)->save();

        flash('Метка успешно создана.')->success();

        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Label $label)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        return view('label.edit', ['label' => $label]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        $data = $request->validate(
            [
                'name'           => 'required',
                'description'    => 'nullable|string',
            ],
            [
                'name.required' => 'Это обязательное поле',
            ]
        );

        $label->fill($data)->save();

        flash('Метка успешно обновлена.')->success();

        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash('Не удалось удалить метку')->error();

            return redirect()->route('labels.index', ['error' => 'has_linked_tasks']);
        }

        $label->delete();

        flash('Метка успешно удалена.')->success();

        return redirect()->route('labels.index');
    }
}
