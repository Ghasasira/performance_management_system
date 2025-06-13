<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TasksController;
use App\Http\Controllers\Api\ReportsController;
use App\Http\Controllers\Api\SuperviseesController;
use App\Http\Controllers\Api\ScoringController;
use App\Http\Controllers\Api\CultureCategoriesController;
use App\Http\Controllers\Api\WorkxoController;
use App\Http\Middleware\JwtMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Get authenticated user info
Route::get('/test', function (Request $request) {
    return response()->json([
        'success' => true,
        'data' => "test"
    ]);
});

// attachments route
Route::get('/attachments/{file}', function ($file) {
    $path = storage_path("app/private-attachments/{$file}");
    return response()->file($path);
});


Route::get('/quarters', [TasksController::class, 'fetchAllQuaters'])->middleware([JwtMiddleware::class]);

// ==========================================
// TASK MANAGEMENT ROUTES
// ==========================================
Route::prefix('personal')->group(function () {
    Route::get('/tasks/{userId}/get', [TasksController::class, 'fetchActiveQuaterTasks'])->middleware([JwtMiddleware::class]);
    Route::get('/tasks/{userId}/history', [TasksController::class, 'fetchQuaterPlusTasks'])->middleware([JwtMiddleware::class]);
    Route::post('/tasks/{userId}/create', [TasksController::class, 'createNewTask'])->middleware([JwtMiddleware::class]);
    Route::post('/tasks/update', [TasksController::class, 'updateTask'])->middleware([JwtMiddleware::class]);
    Route::delete('/tasks/{taskId}/delete', [TasksController::class, 'destroyTask'])->middleware([JwtMiddleware::class]);

    // Task actions
    Route::post('/tasks/{taskId}/submit', [TasksController::class, 'submitTask'])->middleware([JwtMiddleware::class]);

    // Culture scores
    Route::get('/culture/{userId}/scores', [TasksController::class, 'getCultureScoresForQuarter'])->middleware([JwtMiddleware::class]);
    Route::get('/culture/{userId}/details', [TasksController::class, 'getCultureDetailsForQuarter'])->middleware([JwtMiddleware::class]);
});

// ==========================================
// REPORTS ROUTES
// ==========================================
Route::prefix('reports')->group(function () {
    // Current quarter provisional report
    // Route::get('/', [ReportsController::class, 'index'])->name('index');

    // Generate quarter reports
    Route::get('/generate', [ReportsController::class, 'generatePersonalReport'])->middleware([JwtMiddleware::class]);

    Route::get("/departmental-report", [ReportsController::class, "show_departmental_report"])->middleware([JwtMiddleware::class]);
    Route::get("/overall-report", [ReportsController::class, "showAnyReport"])->middleware([JwtMiddleware::class]);

    // Get available report quarters
    Route::get('/available', [ReportsController::class, 'getAvailableReports'])->name('available')->middleware([JwtMiddleware::class]);
});

// ==========================================
// SUPERVISEES ROUTES (Supervisor Only)
// ==========================================
Route::prefix('supervisees')->name('supervisees.')->group(function () {
    // List all supervisees with current quarter tasks
    Route::get('/{userId}/fetch-supervisees', [SuperviseesController::class, 'fetchSupervisees'])->middleware([JwtMiddleware::class]);

    // Get specific supervisee details with tasks for active quarter
    Route::get('/{superviseeId}/fetch-supervisee-data', [SuperviseesController::class, 'showSupervisee'])->middleware([JwtMiddleware::class]);

    // Get supervisee's tasks for specific quarter
    // Route::get('/{id}/tasks', [SuperviseesController::class, 'getQuarterTasks']);
});

// ==========================================
// SCORING ROUTES (Supervisor Only)
// ==========================================
Route::prefix('scoring')->group(function () {
    // Task scoring
    Route::post('/tasks/score', [ScoringController::class, 'scoreTask'])->middleware([JwtMiddleware::class]);
    Route::post('/tasks/bulk', [ScoringController::class, 'bulkScoreTasks'])->middleware([JwtMiddleware::class]);

    // Task management actions
    Route::post('/tasks/approve', [ScoringController::class, 'approveTask'])->middleware([JwtMiddleware::class]);
    Route::post('/tasks/defer', [ScoringController::class, 'deferTask'])->middleware([JwtMiddleware::class]);

    // Culture scoring
    Route::post('/culture/equity', [CultureCategoriesController::class, 'updateEquity'])->middleware([JwtMiddleware::class]);
    Route::post('/culture/integrity', [CultureCategoriesController::class, 'updateIntegrity'])->middleware([JwtMiddleware::class]);
    Route::post('/culture/people', [CultureCategoriesController::class, 'updatePeopleSkills'])->middleware([JwtMiddleware::class]);
    Route::post('/culture/excellence', [CultureCategoriesController::class, 'updateExcellence'])->middleware([JwtMiddleware::class]);
    Route::post('/culture/teamwork', [CultureCategoriesController::class, 'updateTeamWork'])->middleware([JwtMiddleware::class]);
    // Route::get('/culture/categories', [ScoringController::class, 'getCultureCategories']);

    // Scoring history
    // Route::get('/history/{userId}', [ScoringController::class, 'getScoringHistory']);
});


Route::prefix("workxo")->group(function () {
    // In your api.php routes file
    Route::get('/departments', [WorkxoController::class, 'getDepartments'])->middleware([JwtMiddleware::class]);
    Route::get('/departments/{departmentId}/members', [WorkxoController::class, 'getDepartmentMembers'])->middleware([JwtMiddleware::class]);
    Route::get('/departments-with-members', [WorkxoController::class, 'getAllDepartmentsWithMembers'])->middleware([JwtMiddleware::class]);
});

// ==========================================
// ADDITIONAL UTILITY ROUTES
// ==========================================

// Dashboard stats for current user
Route::get('/dashboard/stats', function (Request $request) {
    $userId = auth()->user()->userId;
    $currentQuarter = \App\Models\Quarter::where('is_active', true)->first();

    if (!$currentQuarter) {
        return response()->json([
            'success' => false,
            'message' => 'No active quarter found'
        ], 400);
    }

    $tasks = \App\Models\Task::where('user_id', $userId)
        ->where('quarter_id', $currentQuarter->id)
        ->get();

    $stats = [
        'current_quarter' => $currentQuarter,
        'total_tasks' => $tasks->count(),
        'approved_tasks' => $tasks->where('is_approved', true)->count(),
        'submitted_tasks' => $tasks->where('status', 'submitted')->count(),
        'pending_tasks' => $tasks->where('status', 'pending')->count(),
        'graded_tasks' => $tasks->where('status', 'graded')->count(),
        'deferred_tasks' => $tasks->where('status', 'deferred')->count(),
        'total_weight' => $tasks->sum('weight'),
        'approval_rate' => $tasks->count() > 0 ?
            round(($tasks->where('is_approved', true)->count() / $tasks->count()) * 100, 2) : 0,
        'tasks_with_unread_comments' => $tasks->filter(function ($task) {
            return $task->hasUnreadComments();
        })->count()
    ];

    return response()->json([
        'success' => true,
        'data' => $stats
    ]);
})->name('dashboard.stats');

// Supervisor dashboard stats
Route::get('/supervisor/dashboard/stats', function (Request $request) {
    $supervisorId = auth()->user()->userId;
    $currentQuarter = \App\Models\Quarter::where('is_active', true)->first();

    if (!$currentQuarter) {
        return response()->json([
            'success' => false,
            'message' => 'No active quarter found'
        ], 400);
    }

    $supervisees = \App\Models\User::where('supervisor_id', $supervisorId)->get();
    $superviseeIds = $supervisees->pluck('userId');

    $tasks = \App\Models\Task::whereIn('user_id', $superviseeIds)
        ->where('quarter_id', $currentQuarter->id)
        ->get();

    $pendingReviews = $tasks->where('status', 'submitted')->count();
    $needsScoring = $tasks->filter(function ($task) use ($supervisorId) {
        return !\App\Models\Task::where('task_id', $task->id)
            ->where('supervisor_id', $supervisorId)
            ->exists();
    })->count();

    $stats = [
        'current_quarter' => $currentQuarter,
        'total_supervisees' => $supervisees->count(),
        'total_supervisee_tasks' => $tasks->count(),
        'pending_reviews' => $pendingReviews,
        'tasks_needing_scoring' => $needsScoring,
        'approved_tasks' => $tasks->where('is_approved', true)->count(),
        'deferred_tasks' => $tasks->where('status', 'deferred')->count(),
        'supervisee_completion_rate' => $tasks->count() > 0 ?
            round(($tasks->where('is_approved', true)->count() / $tasks->count()) * 100, 2) : 0
    ];

    return response()->json([
        'success' => true,
        'data' => $stats
    ]);
})->name('supervisor.dashboard.stats');

// });

// ==========================================
// PUBLIC ROUTES (if any)
// ==========================================

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0'
    ]);
})->name('health');

// API documentation info
Route::get('/info', function () {
    return response()->json([
        'api_name' => 'Task Management API',
        'version' => '1.0.0',
        'description' => 'API for managing tasks, reports, supervisees, and scoring',
        'endpoints' => [
            'tasks' => '/api/tasks',
            'reports' => '/api/reports',
            'supervisees' => '/api/supervisees',
            'scoring' => '/api/scoring'
        ],
        'authentication' => 'Bearer Token (Sanctum)',
        'documentation' => url('/docs') // if you have API docs
    ]);
})->name('info');

/*
|--------------------------------------------------------------------------
| API Route Groups with Middleware
|--------------------------------------------------------------------------
| You can add additional middleware for specific route groups:
| - rate limiting
| - role-based access
| - logging
| - etc.
*/

// Example: Rate limited routes
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // These routes are limited to 60 requests per minute
    // Add resource-intensive endpoints here if needed
});

// Example: Admin only routes (if you have admin functionality)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    // Admin-only endpoints would go here
    // Route::get('/users', [AdminController::class, 'users']);
    // Route::post('/quarters', [AdminController::class, 'createQuarter']);
});

// Example: Supervisor only routes with explicit middleware
Route::middleware(['auth:sanctum', 'role:supervisor'])->group(function () {
    // Duplicate supervisor routes here if you want explicit role checking
    // This would be in addition to the logic checks in the controllers
});

/*
|--------------------------------------------------------------------------
| API Error Handling Routes
|--------------------------------------------------------------------------
| Fallback routes for better error handling
*/

// Catch-all for undefined API routes
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found',
        'available_endpoints' => [
            'GET /api/tasks' => 'List tasks',
            'POST /api/tasks' => 'Create task',
            'GET /api/reports' => 'Get current quarter report',
            'GET /api/supervisees' => 'List supervisees',
            'POST /api/scoring/tasks' => 'Score task',
            'GET /api/health' => 'Health check',
            'GET /api/info' => 'API information'
        ]
    ], 404);
});
