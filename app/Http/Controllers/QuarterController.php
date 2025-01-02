<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Quarter;
use App\Models\Task;
use Illuminate\Http\Request;

class QuarterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quarters = Quarter::all();
        $currentquarter = Quarter::where("is_active", true)->first();
        return view('quarters.index', ['data' => $quarters, "current" => $currentquarter]);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'end_date' => 'required|date',
            'end_date' => 'required|date',
            // "user_id" => 'required',
        ]);

        $input = $request->all();
        $input['is_active'] = true;

        Quarter::where("is_active", true)->update([
            "is_active" => false
        ]);

        try {
            Quarter::create($input);
            smilify('success', 'Process Successful');
            return redirect()->back();
        } catch (\Exception $e) {

            smilify('error', 'Process Unsuccessful');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Quarter $quarter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quarter $quarter)
    {
        // //end quarter
        // $quarter->is_active = false;
        // $quarter->save();

        // $quarteryTasks = 

        // return back()->with("success","successful");
        // Start a transaction
        DB::beginTransaction();

        try {
            // Retrieve tasks of the ending quarter
            $tasks = Task::where('quarter_id', $quarter->id)->get();

            // Loop through each task
            foreach ($tasks as $task) {
                // Retrieve and update all subtasks of the task
                foreach ($task->subtasks as $subtask) {
                    $subtask->status = 'submitted'; // or whatever status change you need
                    $subtask->save();
                }
            }

            // $task->status = 'submitted';
            // $task->save();

            // Update the quarter to mark it as ended
            $quarter->is_active = false;
            $quarter->save();

            // Commit the transaction
            DB::commit();

            smilify('success', 'Process Successful');
            return redirect()->back();
        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();

            smilify('error', 'Process Unsuccessful');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quarter $quarter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quarter $quarter) {}
}
