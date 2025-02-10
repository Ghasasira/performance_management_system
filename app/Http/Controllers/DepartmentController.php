<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $data = Department::all();
        return view("departments.index", ['data' => $data, 'users' => $users]);
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
            'supervisor_id' => 'required',
        ]);

        $input = $request->all();

        $supervisor = User::where('id', $request["supervisor_id"])->first();
        $supervisor->is_supervisor = true;
        $supervisor->save();

        Department::create($input);
        smilify('success', 'Department Created Successfully');
        return redirect("/department");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $users = User::all();
        $dept = Department::find($id);
        //$dept->load("subdepartments");
        return view("departments.departments-details", ["dept" => $dept]);
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
