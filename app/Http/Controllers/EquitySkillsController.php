<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equity;
use App\Models\Culture;
use App\Models\Quarter;

class EquitySkillsController extends Controller
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
            'fair' => 'required|integer|min:1|max:10',
            'equal_opportunity' => 'required|integer|min:1|max:10',
            'non_tribalism' => 'required|integer|min:1|max:10',
            'non_nepotism' => 'required|integer|min:1|max:10',
            'gender_blind' => 'required|integer|min:1|max:10',
            'ethnic_blind' => 'required|integer|min:1|max:10',
            "superviseeId" => 'required',
        ]);

        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {

            $exists = Equity::where('user_id', $validatedData['superviseeId'])->exists();
            if (!$exists) {
                $quarter->equity()->create(['user_id' => $validatedData['superviseeId']]);
            }

            Equity::where('user_id', $validatedData['superviseeId'])->update([
                'fair' => $validatedData['fair'],
                'equal_opportunity' => $validatedData['equal_opportunity'],
                'non_tribalistic' => $validatedData['non_tribalism'],
                'non_nepotistic' => $validatedData['non_nepotism'],
                'gender_blind' => $validatedData['gender_blind'],
                'ethnic_blind' => $validatedData['ethnic_blind'],
            ]);

            $numericalData = $validatedData;
            unset($numericalData['superviseeId']);
            $sum = array_sum($numericalData);

            $equityScore = round(($sum / count($numericalData)) * 0.6, 2);

            Culture::where('user_id', $validatedData['superviseeId'])->update([
                "equity" => $equityScore,
            ]);
            smilify('success', 'Successfully Added');
            return redirect()->back()->with('success', 'successful!');
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
