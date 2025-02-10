<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use Carbon\Carbon;

class LockAllOldTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lock-all-old-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Lock tasks after 7 days
            $tasksToLock = Task::where('created_at', '<=', Carbon::now()->subDays(7))
                ->where('is_locked', false)
                ->get();

            $userLockedCount = 0;
            foreach ($tasksToLock as $task) {
                $task->is_locked = true;
                $task->save();
                $userLockedCount++;

                Log::info("Task {$task->id} locked after 7 days");
            }

            // Lock tasks for admin after 14 days
            $adminLockedTasks = Task::where('created_at', '<=', Carbon::now()->subDays(14))
                ->where('is_admin_locked', false)
                ->get();

            $adminLockedCount = 0;
            foreach ($adminLockedTasks as $task) {
                $task->is_admin_locked = true;
                $task->save();
                $adminLockedCount++;

                Log::info("Task {$task->id} admin-locked after 14 days");
            }

            $this->info("Locked {$userLockedCount} tasks for users and {$adminLockedCount} tasks for admins");
            Log::info("Locked {$userLockedCount} tasks for users and {$adminLockedCount} tasks for admins");

            return 0;
        } catch (\Exception $e) {
            Log::error('Error in LockOldTasks command: ' . $e->getMessage());
            $this->error('An error occurred: ' . $e->getMessage());
            return 1;
        }
    }
}
