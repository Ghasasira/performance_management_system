<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subtask;
use App\Models\Task;

class SubtaskComponent extends Component
{
    public $task_id; // Parent task ID, if applicable
    public $subtasks = [];
    public $newSubtask = '';
    public $showModal = false;

    protected $rules = [
        'newSubtask' => 'required|string|max:255',
    ];

    public function mount($taskId)
    {
        $this->task_id = $taskId;
        $this->loadSubtasks();
    }

    public function displayModal()
    {
        $this->showModal = true;
    }

    public function loadSubtasks()
    {
        $this->subtasks = Subtask::where('task_id', $this->task_id)->get()->toArray();
    }

    public function create()
    {
        $this->validate();

        $task = Task::find($this->task_id);

        $task->subtasks()->create([
            // 'task_id' => $this->task_id,
            'title' => $this->newSubtask,
            'weight' => 0,
        ]);

        $this->newSubtask = '';
        $this->loadSubtasks();
        session()->flash('message', 'Subtask created successfully.');
    }

    public function delete($id)
    {
        Subtask::find($id)->delete();
        $this->loadSubtasks();
        session()->flash('message', 'Subtask deleted successfully.');
    }

    public function markAsComplete($id)
    {
        $subtask = Subtask::find($id);
        $subtask->update(['status' => "Submitted"]);
        $this->loadSubtasks();
        session()->flash('message', 'Subtask marked as complete.');
    }

    public function render()
    {
        return view('livewire.subtask-component');
    }
}
