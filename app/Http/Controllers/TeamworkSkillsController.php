<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teamwork;
use App\Models\Culture;
use App\Models\Quarter;

class TeamworkSkillsController extends Controller
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
            'availability' => 'required|integer|min:0|max:10',
            'discipline' => 'required|integer|min:0|max:10',
            'participatory' => 'required|integer|min:0|max:10',
            'ownership' => 'required|integer|min:0|max:10',
            'good-communicator' => 'required|integer|min:0|max:10',
            'interactive-listener' => 'required|integer|min:0|max:10',
            'provides-feedback' => 'required|integer|min:0|max:10',
            'goes-extra-mile' => 'required|integer|min:0|max:10',
            "superviseeId" => 'required',
        ]);

        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            $exists = Teamwork::where('user_id', $validatedData['superviseeId'])->exists();
            if (!$exists) {
                $quarter->teamwork()->create(['user_id' => $validatedData['superviseeId']]);
            }

            Teamwork::where('user_id', $validatedData['superviseeId'])->update([
                'availability' => $validatedData['availability'],
                'discipline' => $validatedData['discipline'],
                'participatory' => $validatedData['participatory'],
                'ownership' => $validatedData['ownership'],
                'good_communicator' => $validatedData['good-communicator'],
                'interactive_listener' => $validatedData['interactive-listener'],
                'provides_feedback' => $validatedData['provides-feedback'],
                'goes_an_extra_mile' => $validatedData['goes-extra-mile'],
            ]);

            $numericalData = $validatedData;
            unset($numericalData['superviseeId']);
            $sum = array_sum($numericalData);

            $teamworkScore = round(($sum / count($numericalData)) * 0.6, 2);

            Culture::where('user_id', $validatedData['superviseeId'])->update([
                "teamwork" => $teamworkScore,
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
