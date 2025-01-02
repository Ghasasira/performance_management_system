<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Services\TaskScoreCalculatorService;

class SubtaskController extends Controller
{

    protected $taskService;

    // Inject the TaskService into the controller
    public function __construct(TaskScoreCalculatorService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
        $this->taskService->calculateTaskScore($taskId);
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
    public function update(Request $request, int $task, int $subtask)
    {
        // Find the subtask by ID
        $currentSubtask = Subtask::find($subtask);
        if (!$subtask) {
            smilify('error', 'Subtask not found');
            return redirect()->back();
        }

        $maxscore = $currentSubtask->weight;

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
        $currentSubtask->score = $validated['score'];
        $currentSubtask->status = 'approved';
        $currentSubtask->save();

        $this->taskService->calculateTaskScore($currentSubtask->task_id);
        // calculateTaskScore($currentSubtask->task_id);

        // // Find the parent task
        // $task = Task::find($currentSubtask->task_id);
        // if (!$task) {
        //     smilify('error', 'Task not found');
        //     return redirect()->back();
        // }

        // // Calculate the total weight and weighted score of all subtasks
        // $totalSubTaskWeight = $task->subtasks->sum('weight');
        // $totalWeightedScore = $task->subtasks->sum('score');

        // // Calculate the new task score
        // if ($totalSubTaskWeight > 0) {
        //     $new_task_score =  $task->weight * ($totalWeightedScore / $totalSubTaskWeight);
        // } else {
        //     $new_task_score = 0;
        // }

        // // Check if all subtasks are approved
        // if ($task->subtasks->every(fn($subtsk) => $subtsk->status === 'approved')) {
        //     $task->status = "completed";
        // } else {
        //     $task->status = "InProgress";
        // }

        // // Update task score and status
        // $task->score = $new_task_score;
        // $task->save();

        // Success message
        smilify('success', 'Process Successful');
        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $taskId, int $subtask)
    {
        try {
            //dd("subtask {{$subtask}}");
            $currentSubtask = Subtask::find($subtask);
            if (!$currentSubtask) {
                smilify('error', 'Subtask not found');
                return redirect()->back();
            }
            // Find the task by ID
            // $task = Task::findOrFail($taskId);

            // // Delete all subtasks related to the task
            // $task->subtasks()->delete();

            // // Delete the task
            $currentSubtask->delete();

            $this->taskService->calculateTaskScore($currentSubtask->task_id);

            smilify('success', 'Subtask deleted successfully.');
            return back();
        } catch (\Exception $e) {
            //Log::error('Task deletion error: ' . $e->getMessage());
            smilify('error', 'An error occurred while deleting the task and its subtasks.');
            return back()->withErrors(['msg' => 'An error occurred while deleting the task and its subtasks.']);
        }
    }

    public function submit($id)
    {
        $subtask = Subtask::find($id);
        $subtask->status = "Submitted";
        $subtask->save();
        smilify('success', 'Process Successful');
        return back();
    }

    public function approve(Request $request, $subtaskId) {}
}
