<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\Subdepartment;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depts = Department::all();
        $subdepts = Subdepartment::all();
        return view("staff.index", ["depts" => $depts, "subdepts" => $subdepts]);
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

        $validated = $request->validate([
            'role' => 'required|string|max:255',
            "department" => 'required',
            "subdepartment" => 'required',

        ]);
        // $userId = auth()->user()->id;
        $user = User::find(auth()->user()->id);


        $user->staff()->create([
            'role' => $validated['role'],
            'department_id' => $validated['department'],
            'subdepartment_id' => $validated['subdepartment'],
        ]);
        $user->is_staff = true;
        $user->save();
        return view('welcome');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
