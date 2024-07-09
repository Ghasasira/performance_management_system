<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subdepartment;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\Staff;
use App\Models\User;

class StaffSubmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = auth()->user();

        // Retrieve all subdepartments supervised by the current user
        $departments = Subdepartment::where('supervisor_id', $currentUser->id)->get();

        // Check if any department is found
        if ($departments->isEmpty()) {
            return abort(401, 'User is not a supervisor for any department');
        }

        $supervisees = collect();

        // Collect all supervisees from the subdepartments
        foreach ($departments as $department) {
            $dept_supervisees = Staff::where('department_id', $department->id)->get();
            $supervisees = $supervisees->merge($dept_supervisees);
        }

        // Ensure supervisees are unique
        $supervisees = $supervisees->unique('user_id');

        $users = [];

        // Loop through each unique supervisee
        foreach ($supervisees as $supervisee) {
            // Find the user associated with the supervisee's user_id
            $superviseeUser = User::find($supervisee->user_id);
            // Assuming Staff model has a user_id

            // Check if user is found (optional, handle cases where user might be missing)
            if ($superviseeUser) {
                $users[] = $superviseeUser; // Add the user to the users array
            }
        }

        return view("tasks.supervisees", ["data" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $supervisee)
    {
        // Find the user along with their tasks and submitted subtasks
        $user = User::with('tasks.subtasks')->find($supervisee->id);

        // Check if user is found (optional)
        if (!$user) {
            return abort(404, 'User not found');
        }

        // Transform the data structure to include tasks and their submitted subtasks
        $data = $user->tasks->map(function ($task) {
            $submittedSubtasks = $task->subtasks->whereIn('status', ['submitted', 'approved']);
            return [
                'task' => $task,
                'subtasks' => $submittedSubtasks,
            ];
        });

        return view('tasks.submitted', ['data' => $data, 'superviseeId' => $supervisee->id]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
