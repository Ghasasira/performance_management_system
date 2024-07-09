<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Culture;
use App\Models\Quarter;
use App\Models\People;
use App\Models\Excellence;
use App\Models\Teamwork;
use App\Models\Equity;
use App\Models\Integrity;
use App\Models\Task;

class CultureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user()->id;
        $quarter=Quarter::where('is_active', true)->first();
        
        if($quarter){
            $data = Culture::where('user_id', $user)
            ->where('quarter_id', $quarter->id)
            ->first();
            if($data){
                return view("culture.index",["data"=>$data]);
            }else{
                return view("culture.index",["data"=>null]);
            }            
        } else if(!$quarter){
            return view("util.no-quarter");
        }
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        //return view('culture.culture-submit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // $user_id= auth()->user()->id;
    
        // try {
        //     Culture::create($user_id);
        //     return dump("created");
        // } catch (\Exception $e) {
        //     // Handle creation errors (e.g., log the error, display a user-friendly message)
        //     return back()->withErrors(['error' => 'Failed to create task.']);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $quarter=Quarter::where('is_active', true)->first();

    $integrityData = Integrity::where('user_id', $user->id)->where('quarter_id', $quarter->id)->get();
    $equityData = Equity::where('user_id', $user->id)->where('quarter_id', $quarter->id)->get();
    $peopleData = People::where('user_id', $user->id)->where('quarter_id', $quarter->id)->get();
    $excellenceData = Excellence::where('user_id', $user->id)->where('quarter_id', $quarter->id)->get();
    $teamworkData = Teamwork::where('user_id', $user->id)->where('quarter_id', $quarter->id)->get();
    
    $cultureData = [
        'integrity' => json_decode($integrityData,true),
        'equity' => json_decode($equityData,true),
        'people' => json_decode($peopleData,true),
        'excellence' => json_decode($excellenceData,true),
        'teamwork' => json_decode($teamworkData,true),
    ];
        return view('culture.culture-details',["data"=>$cultureData]);
        // dump($cultureData);
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

    public function assess($superviseeId)
    {
        $quarter=Quarter::where('is_active', true)->first();

        $exists=Culture::where('user_id',$superviseeId)
        ->where('quarter_id', $quarter->id)
        ->exists();

        if (!$exists) {
            $quarter->culture()->create(['user_id' => $superviseeId]);
        }
        $data = Culture::where('user_id', $superviseeId)
        ->where('quarter_id', $quarter->id)
        ->first();
        //$data = Task::where('user_id',$superviseeId);
        //dump($data);
        return view('culture.culture-submit',["data"=> $data]);
    }
}
