<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subdepartment;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\Staff;
use App\Models\User;

class SubmissionsController extends Controller
{
    public function getSupervisedTasks()
    {
        // Get the logged-in user
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
            $superviseeUser = User::find($supervisee->user_id); // Assuming Staff model has a user_id

            // Check if user is found (optional, handle cases where user might be missing)
            if ($superviseeUser) {
                $users[] = $superviseeUser; // Add the user to the users array
            }
        }

        return view("tasks.supervisees", ["data" => $users]);
    }
}