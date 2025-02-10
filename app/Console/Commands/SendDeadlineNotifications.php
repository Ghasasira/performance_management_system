<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Quarter;
use App\Services\DeadlineNotification;
use Carbon\Carbon;

class SendDeadlineNotifications extends Command
{
    protected $signature = 'notifications:deadlines';
    protected $description = 'Send notifications for approaching task and quarter deadlines';

    public function handle()
    {
        // Task Deadline Notifications (7 days before deadline)
        $tasks = Task::where('deadline', '<=', Carbon::now()->addDays(7))
            ->where('deadline', '>', Carbon::now())
            ->get();

        foreach ($tasks as $task) {
            $task->user->notify(new DeadlineNotification('task', $task));
        }

        // Quarter End Notifications (14 days before quarter end)
        $quarters = Quarter::where('is_active', true)
            ->where('end_date', '<=', Carbon::now()->addDays(14))
            ->where('end_date', '>', Carbon::now())
            ->get();

        foreach ($quarters as $quarter) {
            $quarter->tasks->map(function($task) use ($quarter) {
                $task->user->notify(new DeadlineNotification('quarter', $quarter));
            });
        }
    }
}
