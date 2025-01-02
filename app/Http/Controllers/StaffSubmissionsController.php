<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\Staff;
use App\Models\User;
use App\Models\Quarter;

class StaffSubmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = auth()->user();

        // $quarters = Quarter::where('is_active', false)->get();
        $quarters = Quarter::get();

        if ($currentUser->groupId == 53 || $currentUser->classification_name == "smt" || $currentUser->classification_name == "tmt") {
            // Retrieve all subdepartments supervised by the current user
            $departments = Department::where('department_id', $currentUser->department_id)->pluck('department_id');

            // Check if any department is found
            if ($departments->isEmpty()) {
                return abort(401, 'User is not a supervisor for any department');
            }

            if ($currentUser->classification_name == "tmt") {
                // Fetch all users classified as normal users (exclude SMTs and TMTs)
                $supervisees = User::where('department_id', $currentUser->department_id)
                    ->whereIn('classification_name', ['smt', 'tmt', " "])
                    ->where('userId', "!=", $currentUser->userId)
                    ->with('job')
                    ->get();
            } elseif ($currentUser->classification_name == "smt") {
                // Fetch all users except TMTs in the same department
                $supervisees = User::where('department_id', $currentUser->department_id)
                    ->where(function ($query) {
                        $query->whereNull('classification_name')
                            ->orWhereNotIn('classification_name', ['smt', 'tmt']);
                    })
                    ->where('userId', "!=", $currentUser->userId)
                    ->with('job')
                    ->get();
            }
            // Optional: check if any supervisees are found
            if ($supervisees->isEmpty()) {
                return abort(404, 'No supervisees found');
            }

            return view("tasks.supervisees", ["data" => $supervisees, "quarters" => $quarters]);
        } else {
            return abort(401, 'User is not authorized to view this page');
        }
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
        // Find the user along with their tasks and subtasks
        $user = User::with('tasks.subtasks')->find($supervisee->userId);

        // Check if user is found (optional)
        if (!$user) {
            return abort(404, 'User not found');
        }

        // List of statuses to compare
        $statusList = ['submitted', 'approved', 'pending'];

        // Convert the status list to lowercase
        $lowercaseStatusList = array_map('strtolower', $statusList);

        // Transform the data structure to include tasks and their submitted subtasks
        $data = $user->tasks->map(function ($task) use ($lowercaseStatusList) {
            $submittedSubtasks = $task->subtasks->filter(function ($subtask) use ($lowercaseStatusList) {
                return in_array(strtolower($subtask->status), $lowercaseStatusList);
            });

            return [
                'task' => $task,
                'subtasks' => $submittedSubtasks,
            ];
        });

        return view('tasks.submitted', ['data' => $data, 'superviseeId' => $supervisee->userId]);
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
