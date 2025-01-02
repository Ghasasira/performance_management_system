<?php

namespace App\Services;

use App\Models\Task;


class TaskScoreCalculatorService
{

    public function calculateTaskScore(int $taskId)
    {

        $task = Task::find($taskId);
        if (!$task) {
            smilify('error', 'Task not found');
            return redirect()->back();
        }

        // Calculate the total weight and weighted score of all subtasks
        $totalSubTaskWeight = $task->subtasks->sum('weight');
        $totalWeightedScore = $task->subtasks->sum('score');

        // Calculate the new task score
        if ($totalSubTaskWeight > 0) {
            $new_task_score =  $task->weight * ($totalWeightedScore / $totalSubTaskWeight);
        } else {
            $new_task_score = 0;
        }

        // Check if all subtasks are approved
        if ($task->subtasks->every(fn($subtsk) => $subtsk->status === 'approved')) {
            $task->status = "completed";
        } else {
            $task->status = "InProgress";
        }

        $task->score = $new_task_score;
        $task->save();
    }
}
