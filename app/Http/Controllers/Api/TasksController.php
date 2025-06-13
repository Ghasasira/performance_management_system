<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Culture;
use App\Models\Quarter;
use App\Models\People;
use App\Models\Excellence;
use App\Models\Teamwork;
use App\Models\Equity;
use App\Models\Integrity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class TasksController extends Controller
{

    /**
     * Display a listing of all quarters
     */
    public function fetchAllQuaters(Request $request)
    {
        try {
            $quarters = Quarter::get();

            return response()->json([
                'success' => true,
                'data' => $quarters
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of user's tasks
     */
    public function fetchActiveQuaterTasks(Request $request, int $userId): JsonResponse
    {
        try {
            $quarter = Quarter::where('is_active', true)->firstOrFail();

            $tasks = Task::where('user_id', $userId)
                ->where('quarter_id', $quarter->id)
                ->with(['subtasks', 'attachments'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($task) {
                    // Process attachments
                    $task->attachments->each(function ($attachment) {
                        // Convert storage path to full URL
                        $attachment->url = asset($attachment->path); // or storage_path() if using non-public files
                    });

                    $task->is_user_locked = $task->isUserLocked();
                    $task->is_admin_locked = $task->isAdminLocked();

                    return $task;
                });

            return response()->json([
                'success' => true,
                'data' => $tasks
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to fetch tasks',
    //             'error' => $e->getMessage()
    //         ], 500);

    /**
     * Fetch User History
     */
    public function fetchQuaterPlusTasks(Request $request, int $userId): JsonResponse
    {
        try {
            // Get the active quarter
            $activeQuarter = Quarter::where('is_active', true)->firstOrFail();

            // Get all other quarters except the active one
            $quarters = Quarter::where('id', '!=', $activeQuarter->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Prepare the results
            $results = $quarters->map(function ($quarter) use ($userId) {
                // Fetch tasks for each quarter for the given user
                $tasks = Task::where('user_id', $userId)
                    ->where('quarter_id', $quarter->id)
                    ->with(['subtasks', 'attachments'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Add computed properties
                $tasks->each(function ($task) {
                    $task->is_user_locked = $task->isUserLocked();
                    $task->is_admin_locked = $task->isAdminLocked();
                });

                return [
                    'quarter' => $quarter,
                    'tasks' => $tasks,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Active quarter not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created task
     */
    public function createNewTask(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'deadline' => 'nullable|date|after:today',
                'weight' => 'required|numeric|min:0|max:70',
                'user_id' => 'required|numeric'
            ]);


            $quarter = Quarter::where('is_active', true)->firstOrFail();

            $task = $quarter->tasks()->create([
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'weight' => $validated['weight'],
                'deadline' => $validated['deadline'] ?? $quarter->end_date,
            ]);

            $task = Task::with(['subtasks', 'attachments'])->find($task->id);

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'data' => $task
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task - database error',
                'error' => $e->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified task
     */
    public function show($id): JsonResponse
    {
        try {
            $task = Task::where('id', $id)
                ->where('user_id', Auth::user()->userId)
                ->with(['quarter', 'subtasks', 'attachments', 'actions'])
                ->firstOrFail();

            // Add computed properties
            // $task->has_unread_comments = $task->hasUnreadComments();
            $task->is_user_locked = $task->isUserLocked();
            $task->is_admin_locked = $task->isAdminLocked();

            return response()->json([
                'success' => true,
                'data' => $task
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified task
     */
    public function updateTask(Request $request): JsonResponse
    {
        try {
            $task = Task::findOrFail($request->taskId);

            // Check if task is locked
            if ($task->isAdminLocked()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task is locked and cannot be modified'
                ], 403);
            }

            $validated = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'deadline' => 'nullable|date|after:today',
                'weight' => 'required|numeric|min:0|max:70'
            ]);


            $task->title = $validated['title'];
            $task->description = $validated['description'];
            $task->weight = $validated['weight'];
            $task->deadline = $validated['deadline'];
            $task->save();


            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully',
                'data' => $task
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task',
                $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified task
     */
    public function destroyTask(Request $request, int $taskId): JsonResponse
    {
        try {

            $task = Task::findOrFail($taskId);

            // Check if task is locked
            if ($task->isUserLocked() || $task->isAdminLocked()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task is locked and cannot be deleted'
                ], 403);
            }
            // deletion
            $task->subtasks()->delete();
            $task->attachments()->delete();
            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit task for review
     */
    public function submitTask(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'taskId' => 'required',
                "userId" => "required",
            ]);

            $task = Task::where('id', $validated["taskId"])
                ->where('user_id', $validated["userId"])
                ->firstOrFail();


            // $task->submitTask();
            $task->status = 'submitted';
            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'Task submitted successfully',
                'data' => $task->fresh()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's culture scores
     */
    public function getCultureScoresForQuarter(Request $request, int $userId): JsonResponse
    {
        try {
            $quarter = Quarter::where('is_active', true)->first();

            if (!$quarter) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active quarter found'
                ], 400);
            }

            $cultureScores = Culture::where('user_id', $userId)
                ->where('quarter_id', $quarter->id)
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'quarter' => $quarter,
                    'scores' => $cultureScores
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch culture scores',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCultureDetailsForQuarter(Request $request, int $userId): JsonResponse
    {
        try {
            $quarter = Quarter::where('is_active', true)->first();

            if (!$quarter) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active quarter found'
                ], 400);
            }

            $integrityData = Integrity::where('user_id', $userId)->where('quarter_id', $quarter->id)->get();
            $equityData = Equity::where('user_id', $userId)->where('quarter_id', $quarter->id)->get();
            $peopleData = People::where('user_id', $userId)->where('quarter_id', $quarter->id)->get();
            $excellenceData = Excellence::where('user_id', $userId)->where('quarter_id', $quarter->id)->get();
            $teamworkData = Teamwork::where('user_id', $userId)->where('quarter_id', $quarter->id)->get();

            $cultureData = [
                'integrity' => json_decode($integrityData, true),
                'equity' => json_decode($equityData, true),
                'people' => json_decode($peopleData, true),
                'excellence' => json_decode($excellenceData, true),
                'teamwork' => json_decode($teamworkData, true),
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'culture details' => $cultureData
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch culture scores',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
