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
        // dd($currentUser->classification_name,);
        // Check if any department is found
        // if (!in_array($currentUser->classification_name, ['exco', 'tmt', 'smt'])) {
        //     return abort(401, 'User is not a supervisor for any department');
        // }

        // Check if the user is authorized
        if (!in_array($currentUser->classification_name, ['exco', 'tmt', 'smt'])) {
            return abort(401, 'User is not authorized to view this page');
        }

        // Fetch all quarters
        $quarters = Quarter::get();

        // Fetch supervisees based on the user's classification
        $supervisees = User::where('department_id', $currentUser->department_id)
            ->where('userId', '!=', $currentUser->userId)
            ->when($currentUser->classification_name == 'exco', function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['exco']);
                });
            })
            ->when($currentUser->classification_name == 'tmt', function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['tmt', 'exco']);
                });
            })
            ->when($currentUser->classification_name == 'smt', function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['smt', 'tmt']);
                });
            })
            ->with('job')
            ->get();

        // Check if supervisees are found
        if ($supervisees->isEmpty()) {
            return abort(404, 'No supervisees found');
        }

        return view('tasks.supervisees', ['data' => $supervisees, 'quarters' => $quarters]);
    }


    // $currentUser->groupId == 53 ||

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
        // Step 1: Fetch the active quarter
        $activeQuarter = Quarter::where('is_active', true)->first();

        // Debugging: Check if active quarter exists
        if (!$activeQuarter) {
            return abort(404, 'No active quarter found');
        }

        return view('tasks.submitted', ['superviseeId' => $supervisee->userId]);
    }
}
