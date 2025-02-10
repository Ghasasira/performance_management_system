<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Quarter;

class DepartmentUsers extends Component
{

    public $departmentId;
    public $users = [];
    public $selectedUserId = null;
    public $tasks = [];

    public function mount($departmentId)
    {
        $this->departmentId = $departmentId;
        $this->fetchUsers();
    }

    public function fetchUsers()
    {
        $this->users = User::where('department_id', $this->departmentId)->get();
        // dd($this->users);
    }

    public function showUserTasks($userId)
    {
        $activeQuarter = Quarter::where('is_active', true)->first();
        // $this->selectedUserId = $userId;
        // $this->tasks = User::with('tasks')->find($userId)?->tasks ?? collect();

        if ($activeQuarter) {
            $this->selectedUserId = $userId;
            $this->tasks = User::with(['tasks' => function ($query) use ($activeQuarter) {
                $query->where('quarter_id', $activeQuarter->id);
            }])->find($userId)?->tasks ?? collect();
        } else {
            $this->tasks = collect(); // No active quarter, so no tasks
        }
    }

    public function clearSelectedUser()
    {
        $this->selectedUserId = null;
        $this->tasks = collect();
    }

    public function render()
    {
        return view('livewire.department-users', [
            // 'users' => $this->users,
            // 'tasks' => $this->tasks,
            // 'selectedUserId' => $this->selectedUserId
        ]);
    }
}
