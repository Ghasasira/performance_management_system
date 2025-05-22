<?php

namespace App\Livewire;

use App\Models\Quarter;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TasksTable extends Component
{
    use WithPagination;

    public $quarterName = "";
    public $quarter;
    public $taskId = null;
    public $title = '';
    public $description = '';
    public $weight = '';
    public $deadline = null;
    public $status = '';
    public $user;
    public $isEditing = false;
    public $isModalOpen = false;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'description' => 'required',
        'weight' => 'required|numeric|min:1',
        'deadline' => 'nullable|date|after:today',
        // 'status' => 'in:pending,submitted,graded,differed'
    ];

    public function mount()
    {
        $this->user = auth()->user()->userId;
        $this->quarter = Quarter::where('is_active', true)->first();

        if ($this->quarter) {
            // $this->quarterId = $quarter->id;
            $this->quarterName = $this->quarter->name;
        } else {
            return redirect()->route('no-quarter');
        }

        $this->user = auth()->user()->userId;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->isModalOpen = true;
    }

    public function openEditModal($id)
    {
        $task = Task::findOrFail($id);

        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->weight = $task->weight;
        $this->deadline = $task->deadline;
        // $this->status = $task->status;


        $this->isEditing = true;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();
        // dd($this->validate());

        try {
            $this->quarter->tasks()->create([
                'user_id' => $this->user,
                'title' => $this->title,
                'description' => $this->description,
                'weight' => $this->weight,
                'deadline' => $this->deadline != null ? $this->deadline : $this->quarter->end_date,
                // 'status' => $this->status,
                // 'quarter_id' => $this->quarterId,
            ]);
            // dd("passed");
            $this->resetForm();
            $this->isModalOpen = false;
            smilify('success', 'Task created successfully!');
        } catch (\Exception $e) {
            // dd("failed");
            smilify('error', 'Failed to create task: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate();
        // dd($this->validate());

        try {
            $task = Task::findOrFail($this->taskId);

            // dd("starting............");
            $task->editTask([
                'title' => $this->title,
                'description' => $this->description,
                'weight' => $this->weight,
                'deadline' => $this->deadline,
                // 'status' => $this->status
            ]);

            $this->resetForm();
            $this->isModalOpen = false;
            smilify('success', 'Task updated successfully!');
        } catch (\Exception $e) {
            smilify('error', 'Failed to update task: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->reset([
            'taskId',
            'title',
            'description',
            'weight',
            'deadline',
            'status',
            'isEditing'
        ]);
    }

    public function delete($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->deleteTask();

            smilify('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            smilify('error', 'Failed to delete task: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $data = Task::where('user_id', $this->user)->where('quarter_id', $this->quarter->id)->paginate(10);
        return view('livewire.tasks-table', compact('data'));
    }
}
