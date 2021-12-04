<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->get();
        //$tasks= auth()->user()->tasks;
        //$tasks= auth()->user()->tasks()->get();
        //$tasks=Auth::user()->tasks;
        //$tasks=Auth::user()->tasks()->get();
        $data = ['tasks'=>$tasks];
        return view('tasks.index', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        //$request->user()->tasks()->create( $request->all() );
        //auth()->user()->tasks()->create( $request->all() );

        return redirect('/tasks');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task); //可註解或略過
        $task->delete();
        return redirect('/tasks');
    }
}
