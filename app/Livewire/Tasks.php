<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\User;
use Livewire\WithPagination;

class Tasks extends Component
{
    use withPagination;
    // public function render()
    // {
    //     $user = auth()->user()->id;
    //     // User::all();
    //     $tasks = Task::where('user_id',auth()->user()->id)
    //     ->paginate(10);
    //     return view('livewire.tasks',['data'=> $tasks,'user'=>$user]);
    // }

    // public $createNewTask = false;
    // public $deleteTask = false;

    // public function createNewTask(){
    //     $this->createNewTask = true;
    // }

    // public function deleteTask(Task $task){
    //     $task->delete();
    //     $this->deleteTask = true;
    // }

}
