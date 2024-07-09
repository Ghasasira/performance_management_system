<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Quarter;
use App\Models\Subtask;
use Carbon\Carbon;

class CheckDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-deadlines';

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
        //
        $now = Carbon::now();

        $quarter = Quarter::where('end_date', '<=', $now)
            ->where('is_active', '=', true)
            ->first();

        if ($quarter) {
            // $quarter->is_active = false;
            // $quarter->save();


            $tasks = $quarter->tasks()
                // ->where('deadline', '<=', $now)
                ->where('status', '!=', 'completed')
                ->get();

            foreach ($tasks as $task) {
                // Perform necessary actions, e.g., mark as overdue, notify users, etc.
                $task->status = 'overdue';
                // $task->subtasks->status = 'submitted';

                foreach ($task->subtasks as $subtask) {
                    $subtask->status = 'submitted';
                    $subtask->save();
                }

                $task->save();
            }
        }

        $this->info('Checked for deadlines.');
        return 0;
    }
}
