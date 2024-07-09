<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Integrity;
use App\Models\Culture;
use App\Models\Quarter;

class IntegritySkillsController extends Controller
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
            'honesty' => 'required|integer|min:0|max:10',
            'trustworthy' => 'required|integer|min:0|max:10',
            'reliable' => 'required|integer|min:0|max:10',
            'truth-telling' => 'required|integer|min:0|max:10',
            'accountable' => 'required|integer|min:0|max:10',
            'loyal' => 'required|integer|min:0|max:10',
            "superviseeId" => 'required',
        ]);

        $quarter = Quarter::where('is_active', true)->first();

        if ($quarter) {
            $exists = Integrity::where('user_id', $validatedData['superviseeId'])->exists();
            if (!$exists) {
                $quarter->integrity()->create(['user_id' => $validatedData['superviseeId']]);
            }

            Integrity::where('user_id', $validatedData['superviseeId'])->update([
                'honest' => $validatedData['honesty'],
                'trustworthy' => $validatedData['trustworthy'],
                'reliable' => $validatedData['reliable'],
                'truthtelling' => $validatedData['truth-telling'],
                'accountable' => $validatedData['accountable'],
                'loyal' => $validatedData['loyal'],
            ]);

            $numericalData = $validatedData;
            unset($numericalData['superviseeId']);
            $sum = array_sum($numericalData);

            $integrityScore = round(($sum / count($numericalData)) * 0.6, 2);

            Culture::where('user_id', $validatedData['superviseeId'])->update([
                "integrity" => $integrityScore,
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
