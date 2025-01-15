<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\User;
use App\Models\Quarter;
use Livewire\Component;
use Livewire\WithPagination;

class Taskss extends Component
{
    use WithPagination;

    public $title, $description, $weight, $deadline, $status, $taskId;
    public $quarterName;
    public $user;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'weight' => 'required|integer',
        'deadline' => 'date',
        'status' => 'required|string',
    ];

    public function mount()
    {
        $this->user = auth()->user()->userId;
        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            $this->quarterName = $quarter->name;
        } else {
            return redirect()->route('no-quarter');
        }
    }

    public function render()
    {
        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            $tasks = Task::where('user_id', $this->user)
                ->where('quarter_id', $quarter->id)
                ->paginate(10);

            return view('livewire.tasks-table', [
                'tasks' => $tasks,
            ]);
        }

        return view('livewire.no-quarter');
    }

    public function store()
    {
        $this->validate();

        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            try {
                Task::create([
                    'title' => $this->title,
                    'description' => $this->description,
                    'weight' => $this->weight,
                    'deadline' => $this->deadline,
                    'user_id' => $this->user,
                    'quarter_id' => $quarter->id,
                ]);

                $this->resetForm();
                smilify('success', 'Task created successfully!');
            } catch (\Exception $e) {
                smilify('error', 'An error occurred while creating the task.');
            }
        }
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);

        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->weight = $task->weight;
        $this->deadline = $task->deadline;
        $this->status = $task->status;
    }

    public function update()
    {
        $this->validate();

        $task = Task::findOrFail($this->taskId);

        try {
            $task->update([
                'title' => $this->title,
                'description' => $this->description,
                'weight' => $this->weight,
                'deadline' => $this->deadline,
                'status' => $this->status,
            ]);

            $this->resetForm();
            smilify('success', 'Task update-d successfully!');
        } catch (\Exception $e) {
            smilify('error', 'An error occurred while updating the task.');
        }
    }

    public function delete($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->subtasks()->delete();
            $task->delete();

            smilify('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            smilify('error', 'An error occurred while deleting the task.');
        }
    }

    private function resetForm()
    {
        $this->title = null;
        $this->description = null;
        $this->weight = null;
        $this->deadline = null;
        $this->status = null;
        $this->taskId = null;
    }
}
