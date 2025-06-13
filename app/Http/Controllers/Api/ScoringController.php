<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskScore;
use App\Models\CultureScore;
use App\Models\Task;
use App\Models\User;
use App\Models\CultureCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ScoringController extends Controller
{
    /**
     * Score a supervisee's task
     */
    public function scoreTask(Request $request)
    {
        try {
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'score' => 'required|numeric|min:0|max:100'
            ]);

            $task = Task::findOrFail($validated['task_id']);

            $task->score = $validated['score'];
            $task->status = 'graded';
            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'Task scored successfully',
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
        } catch (AccessDeniedHttpException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error while scoring task'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to score task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve a supervisee's task
     */
    public function approveTask(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
            ]);

            $task = Task::findOrFail($validated['task_id']);

            // $task->update([
            $task->is_approved = true;
            $task->is_admin_locked = true;
            $task->is_locked = true;
            $task->status = strtolower($task->status) == "pending" ? "approved" : $task->status;
            // ]);

            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'Task approved successfully',
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
        } catch (AccessDeniedHttpException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Defer a supervisee's task
     */
    public function deferTask(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
            ]);

            $task = Task::findOrFail($validated['task_id']);

            $task->status = "deferred";
            // ]);
            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'Task deferred successfully',
                'data' => $task->fresh()
            ], 201);
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
        } catch (AccessDeniedHttpException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to defer task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
