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
        // $this->taskService->calculateTaskScore($taskId);
        smilify('success', 'Subtask created Successfully.');
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

            // // Delete the task
            $currentSubtask->delete();

            // $this->taskService->calculateTaskScore($currentSubtask->task_id);

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
        try {
            $subtask = Subtask::find($id);
            $subtask->status = "Submitted";
            $subtask->save();
            smilify('success', 'Process Successful');
            return back();
        } catch (\Exception $e) {
            smilify('error', 'An error occurred while submitting the task and its subtasks.');
        }
    }

    public function approve(Request $request, $subtaskId) {}
}
