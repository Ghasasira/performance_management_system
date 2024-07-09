<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Quarter;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user()->id;
        // User::all();
        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            $tasks = Task::where('user_id', auth()->user()->id)
                ->where('quarter_id', $quarter->id)
                ->paginate(10);
            return view('tasks.index', ['data' => $tasks, 'user' => $user, 'quarter' => $quarter->name]);
        } else if (!$quarter) {
            return view("util.no-quarter");
        }

        //return view("tasks.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'weight' => 'required|integer',
            'deadline' => 'required|date',
            // "user_id" => 'required',
        ]);

        $quarter = Quarter::where('is_active', true)->first();;

        if ($quarter) {
            $input = $request->all();
            $input['user_id'] = auth()->user()->id;
            $input['quarter_id'] = $quarter->id;

            try {
                $quarter->tasks()->create($input);

                smilify('success', 'Process Successful');
                return back();
            } catch (\Exception $e) {
                // Handle creation errors (e.g., log the error, display a user-friendly message)
                smilify('error', 'Process Unsuccessful');
                return back();
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // $task = Task::find($id);
        $task->load("subtasks");
        return view("tasks.task-details", ["task" => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
