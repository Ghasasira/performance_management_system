<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\Culture;
use App\Models\Quarter;

class PeopleSkillsController extends Controller
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
            'interpersonal-skills' => 'required|integer|min:0|max:10',
            'respectful' => 'required|integer|min:0|max:10',
            'flexible' => 'required|integer|min:0|max:10',
            'emotionally-intelligent' => 'required|integer|min:0|max:10',
            'positive-attitude' => 'required|integer|min:0|max:10',
            'considerate' => 'required|integer|min:0|max:10',
            'courteous' => 'required|integer|min:0|max:10',
            "superviseeId" => 'required',
        ]);

        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            $exists = People::where('user_id', $validatedData['superviseeId'])->exists();
            if (!$exists) {
                $quarter->people()->create(['user_id' => $validatedData['superviseeId']]);
            }

            People::where('user_id', $validatedData['superviseeId'])->update([
                'interperson_relations' => $validatedData['interpersonal-skills'],
                'emotionally_intelligent' => $validatedData['emotionally-intelligent'],
                'respectful' => $validatedData['respectful'],
                'flexible' => $validatedData['flexible'],
                'considerate' => $validatedData['considerate'],
                'couteous' => $validatedData['courteous'],
                'positive_attitude' => $validatedData['positive-attitude'],
            ]);

            $numericalData = $validatedData;
            unset($numericalData['superviseeId']);
            $sum = array_sum($numericalData);

            $equityScore = round(($sum / count($numericalData)) * 0.6, 2);

            Culture::where('user_id', $validatedData['superviseeId'])->update([
                "people" => $equityScore,
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
