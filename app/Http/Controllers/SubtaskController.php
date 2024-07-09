<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;
use App\Models\Task;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($taskId)
    {

        // return view("tasks.create-subtask",['taskId'=>$taskId]);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $taskId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'weight' => 'required|integer',
        ]);

        $task = Task::find($taskId);

        $task->subtasks()->create([
            'title' => $validated['title'],
            'weight' => $validated['weight'],

        ]);

        smilify('success', 'Process Successful');
        return back();
    }
    /**
     * Display the specified resource.
     */
    public function show(Subtask $subtask)
    {
        // return view('attachments.attachment-display');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subtask $subtask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, Subtask $subtask)
    {

        $validated = $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        $subtask->score = $validated['score'];
        $subtask->status = 'approved';
        // Ensure 'approved' matches the status value in your database

        $subtask->save();

        $task = Task::find($subtask->task_id);

        if (!$task) {
            smilify('error', 'Process Unsuccessful');
            return redirect()->back();
        }

        // Calculate the total weight of all subtasks for the task
        $totalSubTaskWeight = 0;
        $totalWeightedScore = 0;

        foreach ($task->subtasks as $subtsk) {
            $totalSubTaskWeight += $subtsk->weight;
            $totalWeightedScore += $subtsk->score;
        }

        $new_task_score =  $task->weight * ($totalWeightedScore / $totalSubTaskWeight);

        if ($task->subtasks->every(fn ($subtsk) => $subtsk->status === 'approved')) {
            $task->status = "completed";
        }

        $task->score = $new_task_score;
        $task->save();

        smilify('success', 'Process Successful');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subtask)
    {
        //
    }

    public function submit($id)
    {
        $subtask = Subtask::find($id);
        $subtask->status = "Submitted";
        $subtask->save();
        smilify('success', 'Process Successful');
        return back();
    }

    public function approve(Request $request, $subtaskId)
    {
    }
}
