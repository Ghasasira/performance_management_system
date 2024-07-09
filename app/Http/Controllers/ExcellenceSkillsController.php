<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Excellence;
use App\Models\Culture;
use App\Models\Quarter;

class ExcellenceSkillsController extends Controller
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
        $validatedData = $request->validate([
            'follow-up' => 'required|integer|min:0|max:10',
            'fast-to-deliver' => 'required|integer|min:0|max:10',
            'good-executor' => 'required|integer|min:0|max:10',
            'effective-communicator' => 'required|integer|min:0|max:10',
            'efficient' => 'required|integer|min:0|max:10',
            'competent' => 'required|integer|min:0|max:10',
            'detailed-planner' => 'required|integer|min:0|max:10',
            'keeps-time' => 'required|integer|min:0|max:10',
            "superviseeId" => 'required',
        ]);

        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            $exists = Excellence::where('user_id', $validatedData['superviseeId'])->exists();
            if (!$exists) {
                $quarter->excellence()->create(['user_id' => $validatedData['superviseeId']]);
            }

            Excellence::where('user_id', $validatedData['superviseeId'])->update([
                'follow_through_and_follow_up' => $validatedData['follow-up'],
                'fast_to_deliver' => $validatedData['fast-to-deliver'],
                'good_executor' => $validatedData['good-executor'],
                'efficient' => $validatedData['efficient'],
                'competent' => $validatedData['competent'],
                'detailed_planner' => $validatedData['detailed-planner'],
                'keeps_time' => $validatedData['keeps-time'],
                'effective_communicator' => $validatedData['effective-communicator'],
            ]);

            $numericalData = $validatedData;
            unset($numericalData['superviseeId']);
            $sum = array_sum($numericalData);

            $equityScore = round(($sum / count($numericalData)) * 0.6, 2);

            Culture::where('user_id', $validatedData['superviseeId'])->update([
                "excellence" => $equityScore,
            ]);

            smilify('success', 'Successfully Added');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
