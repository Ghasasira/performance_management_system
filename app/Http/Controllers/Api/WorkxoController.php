<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Models\Quarter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WorkxoController extends Controller
{
    /**
     * Get all departments
     */
    public function getDepartments(): JsonResponse
    {
        try {
            $departments = Department::select('department_id', 'department_name')
                ->orderBy('department_name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $departments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch departments',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get members of a specific department with their tasks for active quarter
     */
    public function getDepartmentMembers(int $departmentId): JsonResponse
    {
        try {
            // Get active quarter
            $activeQuarter = Quarter::where('is_active', true)->first();

            if (!$activeQuarter) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active quarter found'
                ], 404);
            }

            // Check if department exists
            $department = Department::find($departmentId);
            if (!$department) {
                return response()->json([
                    'success' => false,
                    'message' => 'Department not found'
                ], 404);
            }

            // Get members with their tasks for the active quarter
            $members = User::where('department_id', $departmentId)
                ->select('userId', 'firstName', 'lastName', 'username')
                ->with(['tasks' => function ($query) use ($activeQuarter) {
                    $query->where('quarter_id', $activeQuarter->id)
                        ->select('id', 'user_id', 'title', 'description', 'status', 'score', 'weight', 'deadline',);
                }])
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'department' => [
                        'id' => $department->department_id,
                        'name' => $department->department_name,
                    ],
                    'active_quarter' => [
                        'id' => $activeQuarter->id,
                        'name' => $activeQuarter->name,
                    ],
                    'members' => $members
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch department members',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get all departments with their members and tasks for active quarter
     */
    public function getAllDepartmentsWithMembers(): JsonResponse
    {
        try {
            // Get active quarter
            $activeQuarter = Quarter::where('is_active', true)->first();

            if (!$activeQuarter) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active quarter found'
                ], 404);
            }

            // Get all departments with members and their tasks
            $departments = Department::select('id', 'name', 'description')
                ->with(['users' => function ($query) use ($activeQuarter) {
                    $query->select('id as userId', 'first_name', 'last_name', 'username', 'department_id')
                        ->with(['tasks' => function ($taskQuery) use ($activeQuarter) {
                            $taskQuery->where('quarter_id', $activeQuarter->id)
                                ->select('id', 'user_id', 'title', 'description', 'status', 'priority', 'due_date', 'created_at');
                        }]);
                }])
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'active_quarter' => [
                        'id' => $activeQuarter->id,
                        'name' => $activeQuarter->name,
                        'year' => $activeQuarter->year
                    ],
                    'departments' => $departments
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch departments with members',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
