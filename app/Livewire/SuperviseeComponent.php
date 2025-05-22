<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quarter;
use App\Models\User;
use App\Models\Task;

class SuperviseeComponent extends Component
{
    public $selectedSuperviseeId;
    public $submittedTasks = [];
    public $score;
    public $taskId;
    public $selectedTask;
    public $title = '';
    public $description = '';
    public $weight = '';
    public $deadline = null;
    public $isEditModalOpen = false;
    public $isScoreModalOpen = false;
    public $selectedQuarterId;
    public $quarters = [];
    public $activeQuarterId;

    protected $listeners = ['loadSubmissions' => 'loadTasksForQuarter'];

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'description' => 'required',
        'weight' => 'required|numeric|min:1',
        'deadline' => 'nullable|date|after:today',
    ];

    public function mount($userId)
    {
        $this->selectedSuperviseeId = $userId;
        $this->initializeQuarters();
        $this->loadTasksForQuarter();
    }

    protected function initializeQuarters()
    {
        $this->quarters = Quarter::orderBy('start_date', 'desc')->get();
        $activeQuarter = Quarter::where('is_active', true)->first();
        $this->activeQuarterId = $activeQuarter ? $activeQuarter->id : null;
        $this->selectedQuarterId = $this->activeQuarterId;
    }

    public function updatedSelectedQuarterId()
    {
        $this->reset(['submittedTasks', 'selectedTask', 'taskId']);
        $this->loadTasksForQuarter();
    }

    protected function loadTasksForQuarter()
    {
        if (!$this->selectedQuarterId) {
            $this->submittedTasks = [];
            return;
        }

        $user = User::with(['tasks' => function ($query) {
            $query->where('quarter_id', $this->selectedQuarterId)
                ->with('subtasks');
        }])->find($this->selectedSuperviseeId);

        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        $this->processTasks($user);
    }

    protected function processTasks($user)
    {
        $statusList = ['submitted', 'approved', 'pending', 'graded', 'deferred'];
        $lowercaseStatusList = array_map('strtolower', $statusList);

        $this->submittedTasks = $user->tasks
            ->filter(function ($task) {
                // Make sure we only include tasks from the selected quarter
                return $task->quarter_id == $this->selectedQuarterId;
            })
            ->map(function ($task) use ($lowercaseStatusList) {
                $submittedSubtasks = $task->subtasks->filter(function ($subtask) use ($lowercaseStatusList) {
                    return in_array(strtolower($subtask->status), $lowercaseStatusList);
                });

                return [
                    'task' => $task,
                    'subtasks' => $submittedSubtasks,
                ];
            })->toArray();
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->isEditModalOpen = false;
        $this->isScoreModalOpen = false;
    }

    public function resetForm()
    {
        $this->reset([
            'taskId',
            'title',
            'description',
            'weight',
            'deadline',
            'score'
        ]);
    }

    public function awardTask($id)
    {
        $task = Task::find($id);
        if (!$task) {
            session()->flash('error', 'Task not found.');
            return;
        }

        $this->taskId = $id;
        $this->selectedTask = $task;
        $this->score = $task->score;
        $this->isScoreModalOpen = true;
    }

    public function approveTask($taskId)
    {
        $task = Task::find($taskId);
        if (!$task) {
            session()->flash('error', 'Task not found.');
            return;
        }

        $task->approve(auth()->user());
        session()->flash('success', 'Task approved successfully.');
        $this->loadTasksForQuarter();
    }

    public function openEditModal($id)
    {
        $task = Task::findOrFail($id);
        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->weight = $task->weight;
        $this->deadline = $task->deadline;
        $this->isEditModalOpen = true;
    }

    public function editTask()
    {
        $this->validate();

        try {
            $task = Task::findOrFail($this->taskId);
            $task->editTask([
                'title' => $this->title,
                'description' => $this->description,
                'weight' => $this->weight,
                'deadline' => $this->deadline,
            ]);

            $this->closeModal();
            $this->loadTasksForQuarter();
            session()->flash('success', 'Task updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update task: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->deleteTask();
            session()->flash('success', 'Task and its subtasks deleted successfully.');
            $this->loadTasksForQuarter();
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the task.');
        }
    }

    public function differTask($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->defer();
            session()->flash('success', 'Task status changed to differed.');
            $this->loadTasksForQuarter();
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while differing the task.');
        }
    }

    public function scoreTask()
    {
        $task = Task::find($this->taskId);
        if (!$task) {
            session()->flash('error', 'Task not found.');
            return;
        }

        $this->validate([
            'score' => "required|integer|min:0|max:{$task->weight}"
        ]);

        $task->scoreTask($this->score);
        session()->flash('success', 'Score awarded successfully.');
        $this->closeModal();
        $this->loadTasksForQuarter();
    }

    public function render()
    {
        return view('livewire.supervisee-component');
    }
}
