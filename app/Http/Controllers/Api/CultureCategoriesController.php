<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Culture;
use App\Models\Teamwork;
use App\Models\Quarter;
use App\Models\People;
use App\Models\Integrity;
use App\Models\Excellence;
use App\Models\Equity;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CultureCategoriesController extends Controller
{
    /**
     * Update equity scores for a supervisee
     */
    public function updateEquity(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'fair' => 'required|integer|min:0|max:10',
                'equal_opportunity' => 'required|integer|min:0|max:10',
                'non_tribalism' => 'required|integer|min:0|max:10',
                'non_nepotism' => 'required|integer|min:0|max:10',
                'gender_blind' => 'required|integer|min:0|max:10',
                'ethnic_blind' => 'required|integer|min:0|max:10',
                'superviseeId' => 'required|integer',
            ]);

            $quarter = Quarter::where('is_active', true)->firstOrFail();

            DB::transaction(function () use ($validatedData, $quarter) {
                // Check if record exists, create if not
                $exists = Equity::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$exists) {
                    Equity::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update equity scores
                Equity::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update([
                        'fair' => $validatedData['fair'],
                        'equal_opportunity' => $validatedData['equal_opportunity'],
                        'non_tribalistic' => $validatedData['non_tribalism'],
                        'non_nepotistic' => $validatedData['non_nepotism'],
                        'gender_blind' => $validatedData['gender_blind'],
                        'ethnic_blind' => $validatedData['ethnic_blind'],
                    ]);

                // Calculate weighted score
                $numericalData = $validatedData;
                unset($numericalData['superviseeId']);
                $sum = array_sum($numericalData);
                $equityScore = round(($sum / count($numericalData)) * 0.6, 2);

                $cultureExists = Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$cultureExists) {
                    Culture::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update culture aggregate
                Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update(
                        ['equity' => $equityScore]
                    );

                //  Culture::where('user_id', $validatedData['superviseeId'])->update([
                // 'equity' => $equityScore
                // ]);
            });

            // Get the updated culture data
            $culture = Culture::where('user_id', $validatedData['superviseeId'])
                ->where('quarter_id', $quarter->id)
                ->first();

            return $this->successResponse('Equity scores updated successfully', $culture);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update equity scores', $e);
        }
    }

    /**
     * Update excellence scores for a supervisee
     */
    public function updateExcellence(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'follow-up' => 'required|integer|min:0|max:10',
                'fast-to-deliver' => 'required|integer|min:0|max:10',
                'good-executor' => 'required|integer|min:0|max:10',
                'effective-communicator' => 'required|integer|min:0|max:10',
                'efficient' => 'required|integer|min:0|max:10',
                'competent' => 'required|integer|min:0|max:10',
                'detailed-planner' => 'required|integer|min:0|max:10',
                'keeps-time' => 'required|integer|min:0|max:10',
                'superviseeId' => 'required|integer',
            ]);

            $quarter = Quarter::where('is_active', true)->firstOrFail();

            DB::transaction(function () use ($validatedData, $quarter) {
                // Check if record exists, create if not
                $exists = Excellence::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$exists) {
                    Excellence::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update excellence scores
                Excellence::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update([
                        'follow_through_and_follow_up' => $validatedData['follow-up'],
                        'fast_to_deliver' => $validatedData['fast-to-deliver'],
                        'good_executor' => $validatedData['good-executor'],
                        'efficient' => $validatedData['efficient'],
                        'competent' => $validatedData['competent'],
                        'detailed_planner' => $validatedData['detailed-planner'],
                        'keeps_time' => $validatedData['keeps-time'],
                        'effective_communicator' => $validatedData['effective-communicator'],
                    ]);

                // Calculate weighted score
                $numericalData = $validatedData;
                unset($numericalData['superviseeId']);
                $sum = array_sum($numericalData);
                $excellenceScore = round(($sum / count($numericalData)) * 0.6, 2);

                $cultureExists = Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$cultureExists) {
                    Culture::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update culture aggregate
                Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update(
                        ['excellence' => $excellenceScore]
                    );
            });
            // Get the updated culture data
            $culture = Culture::where('user_id', $validatedData['superviseeId'])
                ->where('quarter_id', $quarter->id)
                ->first();

            return $this->successResponse('Excellence scores updated successfully', $culture);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update excellence scores', $e);
        }
    }

    /**
     * Update integrity scores for a supervisee
     */
    public function updateIntegrity(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'honesty' => 'required|integer|min:0|max:10',
                'trustworthy' => 'required|integer|min:0|max:10',
                'reliable' => 'required|integer|min:0|max:10',
                'truth-telling' => 'required|integer|min:0|max:10',
                'accountable' => 'required|integer|min:0|max:10',
                'loyal' => 'required|integer|min:0|max:10',
                'superviseeId' => 'required|integer',
            ]);

            $quarter = Quarter::where('is_active', true)->firstOrFail();

            DB::transaction(function () use ($validatedData, $quarter) {
                // Check if record exists, create if not
                $exists = Integrity::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$exists) {
                    Integrity::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update integrity scores
                Integrity::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update([
                        'honest' => $validatedData['honesty'],
                        'trustworthy' => $validatedData['trustworthy'],
                        'reliable' => $validatedData['reliable'],
                        'truthtelling' => $validatedData['truth-telling'],
                        'accountable' => $validatedData['accountable'],
                        'loyal' => $validatedData['loyal'],
                    ]);

                // Calculate weighted score
                $numericalData = $validatedData;
                unset($numericalData['superviseeId']);
                $sum = array_sum($numericalData);
                $integrityScore = round(($sum / count($numericalData)) * 0.6, 2);


                $cultureExists = Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$cultureExists) {
                    Culture::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update culture aggregate
                Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update(
                        ['integrity' => $integrityScore]
                    );
            });
            // Get the updated culture data
            $culture = Culture::where('user_id', $validatedData['superviseeId'])
                ->where('quarter_id', $quarter->id)
                ->first();

            return $this->successResponse('Integrity scores updated successfully', $culture);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update integrity scores', $e);
        }
    }

    /**
     * Update people skills scores for a supervisee
     */
    public function updatePeopleSkills(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'interpersonal-skills' => 'required|integer|min:0|max:10',
                'respectful' => 'required|integer|min:0|max:10',
                'flexible' => 'required|integer|min:0|max:10',
                'emotionally-intelligent' => 'required|integer|min:0|max:10',
                'positive-attitude' => 'required|integer|min:0|max:10',
                'considerate' => 'required|integer|min:0|max:10',
                'courteous' => 'required|integer|min:0|max:10',
                'superviseeId' => 'required|integer',
            ]);

            $quarter = Quarter::where('is_active', true)->firstOrFail();

            DB::transaction(function () use ($validatedData, $quarter) {
                // Check if record exists, create if not
                $exists = People::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$exists) {
                    People::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update people skills scores
                People::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update([
                        'interperson_relations' => $validatedData['interpersonal-skills'],
                        'respectful' => $validatedData['respectful'],
                        'flexible' => $validatedData['flexible'],
                        'emotionally_intelligent' => $validatedData['emotionally-intelligent'],
                        'positive_attitude' => $validatedData['positive-attitude'],
                        'considerate' => $validatedData['considerate'],
                        'courteous' => $validatedData['courteous'],
                    ]);

                // Calculate weighted score
                $numericalData = $validatedData;
                unset($numericalData['superviseeId']);
                $sum = array_sum($numericalData);
                $peopleScore = round(($sum / count($numericalData)) * 0.6, 2);

                $cultureExists = Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$cultureExists) {
                    Culture::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update culture aggregate
                Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update(
                        ['people' => $peopleScore]
                    );
            });

            // Get the updated culture data
            $culture = Culture::where('user_id', $validatedData['superviseeId'])
                ->where('quarter_id', $quarter->id)
                ->first();

            return $this->successResponse('People skills scores updated successfully', $culture);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update people skills scores', $e);
        }
    }

    /**
     * Update teamwork scores for a supervisee
     */
    public function updateTeamwork(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'availability' => 'required|integer|min:0|max:10',
                'discipline' => 'required|integer|min:0|max:10',
                'participatory' => 'required|integer|min:0|max:10',
                'ownership' => 'required|integer|min:0|max:10',
                'good-communicator' => 'required|integer|min:0|max:10',
                'interactive-listener' => 'required|integer|min:0|max:10',
                'provides-feedback' => 'required|integer|min:0|max:10',
                'goes-extra-mile' => 'required|integer|min:0|max:10',
                'superviseeId' => 'required|integer',
            ]);

            $quarter = Quarter::where('is_active', true)->firstOrFail();

            DB::transaction(function () use ($validatedData, $quarter) {
                // Check if record exists, create if not
                $exists = Teamwork::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$exists) {
                    Teamwork::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update teamwork scores
                Teamwork::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update([
                        'availability' => $validatedData['availability'],
                        'discipline' => $validatedData['discipline'],
                        'participatory' => $validatedData['participatory'],
                        'ownership' => $validatedData['ownership'],
                        'good_communicator' => $validatedData['good-communicator'],
                        'interactive_listener' => $validatedData['interactive-listener'],
                        'provides_feedback' => $validatedData['provides-feedback'],
                        'goes_an_extra_mile' => $validatedData['goes-extra-mile'],
                    ]);

                // Calculate weighted score
                $numericalData = $validatedData;
                unset($numericalData['superviseeId']);
                $sum = array_sum($numericalData);
                $teamworkScore = round(($sum / count($numericalData)) * 0.6, 2);

                $cultureExists = Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->exists();

                if (!$cultureExists) {
                    Culture::create([
                        'user_id' => $validatedData['superviseeId'],
                        'quarter_id' => $quarter->id
                    ]);
                }

                // Update culture aggregate
                Culture::where('user_id', $validatedData['superviseeId'])
                    ->where('quarter_id', $quarter->id)
                    ->update(
                        ['teamwork' => $teamworkScore]
                    );
            });
            // Get the updated culture data
            $culture = Culture::where('user_id', $validatedData['superviseeId'])
                ->where('quarter_id', $quarter->id)
                ->first();



            return $this->successResponse('Teamwork scores updated successfully', $culture);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to update teamwork scores', $e);
        }
    }

    /**
     * Standardized response methods
     */
    protected function successResponse(string $message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    protected function validationErrorResponse(ValidationException $e)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    }

    protected function serverErrorResponse(string $message, \Exception $e)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}
