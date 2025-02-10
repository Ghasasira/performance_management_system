<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PreventLockedTaskModification
{
    public function handle(Request $request, Closure $next)
    {
        $task = $request->route('task'); // Assumes you're using route model binding
        $currentUser = auth()->user();

        if (!$task) {
            return response()->json([
                'message' => 'Task not found.'
            ], 404);
        }

        // Check for user-level lock
        if ($task->is_locked ) {
            return response()->json([
                'message' => 'This task is locked and cannot be modified by users.'
            ], 403);
        }

        // classification_name
        // Check for admin-level lock
        // Only allow admins to modify admin-locked tasks
        if ($task->is_admin_locked && ($currentUser->groupId != 53 || $currentUser->classification_name != "smt" || $currentUser->classification_name != "tmt")) {
            return response()->json([
                'message' => 'This task is locked and can only be modified by administrators.'
            ], 403);
        }

        return $next($request);
    }
}
