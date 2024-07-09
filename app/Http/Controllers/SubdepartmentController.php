<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class SubdepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($deptId)
    {
        // return view("departments.create-subdepartment",['deptId'=>$deptId]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $departmentId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'supervisor_id' => 'required',
        ]);

        $department = Department::find($departmentId);

        $department->subdepartments()->create([
            'name' => $validated['name'],
            'supervisor_id' => $validated['supervisor_id'],
            

        ]);

        //return redirect()->route('departments.show', $departmentId);
        return redirect()->back();
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
