<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use App\Models\User;
use App\Models\Task;
use App\Models\Quarter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SuperviseesController extends Controller
{
    /**
     * Get list of supervisees with their current quarter tasks
     */
    public function fetchSupervisees(Request $request, int $userId): JsonResponse
    {
        $currentUser = User::findOrFail($userId);

        // Base query (do not execute with ->get() yet)
        $query = User::query()->select(
            "userId",
            "id_no",
            "department_id",
            "job_id",
            "username",
            "groupId",
            "firstName",
            "lastName",
            "primaryTelephone",
            "classification_name"
        )
            ->where('userId', '!=', $currentUser->userId)
            ->with('job');

        // Apply conditions based on user role
        if (strtolower($currentUser->job->job_name) == "group ceo") {
            $query->whereIn('classification_name', ['tmt', 'exco']);
        } elseif (strtolower($currentUser->job->job_name) == "chief of staff") {
            $query->whereIn('classification_name', ['tmt', 'exco']);
        } elseif (strtolower($currentUser->job->job_name) == "chief operations officer") {
            $query->whereIn('department_id', [1, 15]);
            // $query->whereIn('classification_name', ['tmt', 'exco']);
        } elseif (strtolower($currentUser->job->job_name) != "chief of staff") {
            $query->where('department_id', $currentUser->department_id);

            // Apply classification filters
            if ($currentUser->classification_name == 'exco') {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['exco']);
                });
            } elseif ($currentUser->classification_name == 'tmt') {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['tmt', 'exco']);
                });
            } elseif ($currentUser->classification_name == 'smt') {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['smt', 'tmt', 'exco']);
                });
            }
        }

        // Execute query with pagination
        $filteredSupervisees = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => [
                // 'quarter' => $quarter,
                'supervisees' => $filteredSupervisees
            ]
        ]);
    }

    /**
     * Get detailed information about a specific supervisee
     */
    public function showSupervisee(int $userId): JsonResponse
    {
        $supervisee = User::select(['userId', 'firstName', 'lastName'])
            ->findOrFail($userId);

        if (!$supervisee) {
            return response()->json([
                'success' => false,
                'message' => 'Supervisee not found or not under your supervision'
            ], 404);
        }

        $quarter = Quarter::where('is_active', true)->firstOrFail();

        $taskQuery = Task::where('user_id', $userId)->where('quarter_id', $quarter->id)
            ->with(['attachments']);

        // $superviseeCulture = Culture::where('user_id', $userId)->where('quarter_id', $quarter->id)->first();
        $superviseeCulture = Culture::firstOrCreate(
            [
                'user_id' => $userId,
                'quarter_id' => $quarter->id
            ],
            [
                // Optional: default values for new record (if creation happens)
                // 'some_other_column' => 'default_value',
            ]
        );

        $superviseeTasks = $taskQuery->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'supervisee' => $supervisee,
            'tasks' => $superviseeTasks,
            "culture" => $superviseeCulture
        ]);
    }
}
