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
        $user = auth()->user()->userId;
        // User::all();
        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            $tasks = Task::where('user_id', auth()->user()->userId)
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
            $input['user_id'] = auth()->user()->userId;
            $input['quarter_id'] = $quarter->id;

            try {
                $quarter->tasks()->create($input);

                smilify('success', 'Process Successful');
                return back();
            } catch (\Exception $e) {
                // Handle creation errors (e.g., log the error, display a user-friendly message)
                smilify('error', 'Process Unsuccessful');
                return $e;
                //  back();
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
        $task->load('attachments');
        return view("tasks.task-details", ["task" => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'weight' => 'required|integer',
            'deadline' => 'required|date',
            // "user_id" => 'required',
        ]);

        try {
            // Find the task by ID
            $task = Task::findOrFail($id);

            // Update the task
            $task->update($request->all());
            $task->save();
            smilify('success', 'Task status updated successfully.');
            return back();
        } catch (\Exception $e) {
            smilify('error', 'An error occurred while updating the task.');
            return back()->withErrors(['msg' => 'An error occurred while updating the task.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming data
        $request->validate([
            'status' => 'required|string',
        ]);

        try {
            // Find the task by ID
            $task = Task::findOrFail($id);

            // Update the status of the task
            $task->update([
                'status' => $request->input('status'),
            ]);
            smilify('success', 'Task status updated successfully.');
            return redirect()->route('tasks.index');
        } catch (\Exception $e) {
            smilify('error', 'An error occurred while defering the task status.');
            return back()->withErrors(['msg' => 'An error occurred while updating the task status.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            // Find the task by ID
            $task = Task::findOrFail($id);

            // Delete all subtasks related to the task
            $task->subtasks()->delete();

            // Delete the task
            $task->delete();

            smilify('success', 'Task and all its subtasks deleted successfully.');
            return  back();
        } catch (\Exception $e) {
            //Log::error('Task deletion error: ' . $e->getMessage());
            smilify('error', 'An error occurred while deleting the task and its subtasks.');
            return back()->withErrors(['msg' => 'An error occurred while deleting the task and its subtasks.']);
        }
    }

    public function differTask(int $id)
    {
        try {
            // Find the task by ID
            $task = Task::findOrFail($id);

            // Delete all subtasks related to the task
            // $task->subtasks()->delete();

            // Differ the task
            $task->status = "differed";
            $task->save();

            smilify('success', 'Task and all its subtasks differed successfully.');
            return  back();
        } catch (\Exception $e) {
            smilify('error', 'An error occurred while differing the task and its subtasks.');
            return back()->withErrors(['msg' => 'An error occurred while differing the task and its subtasks.']);
        }
    }

    public function score(Request $request, int $task)
    {
        // Find the subtask by ID
        $currentTask = Task::find($task);
        if (!$task) {
            smilify('error', 'Subtask not found');
            return redirect()->back();
        }

        $maxscore = $currentTask->weight;

        // Validate the score input
        $validated = $request->validate([
            'score' => [
                'required',
                'integer',
                'min:0',
                "max:$maxscore",
            ],
        ]);

        // Update the subtask's score and status
        $currentTask->score = $validated['score'];
        $currentTask->status = 'Graded';
        $currentTask->save();

        // $this->taskService->calculateTaskScore($currentSubtask->task_id);
        // calculateTaskScore($currentSubtask->task_id);

        smilify('success', 'Process Successful');
        return back();
    }

    public function submit($id)
    {
        $task = Task::find($id);
        $task->status = "Submitted";
        $task->save();
        smilify('success', 'Process Successful');
        return back();
    }

    public function approve(Request $request, $subtaskId) {}
}
