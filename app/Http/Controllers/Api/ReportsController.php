<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Culture;
// use App\Models\Task;
use App\Models\Quarter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Get list of available report quarters
     */
    public function getAvailableReports(): JsonResponse
    {
        $userId = Auth::user()->userId;

        $availableQuarters = Quarter::whereHas('tasks', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $availableQuarters
        ]);
    }

    public function generatePersonalReport(Request $request)
    {
        // Validate query parameters from the URL
        $request->validate([
            'userId' => 'required|integer|exists:users,userId',
            'quarter_id' => 'required|integer|exists:quarters,id',
        ]);

        // Retrieve validated parameters
        $userId = $request->query('userId');
        $quarterId = $request->query('quarter_id');

        // Find user and quarter
        $user = User::find($userId);
        $quarter = Quarter::find($quarterId);

        // Fetch tasks and culture data
        $tasks = Task::where('quarter_id', $quarter->id)
            ->where('user_id', $user->userId)
            ->get();

        $culture = Culture::where('quarter_id', $quarter->id)
            ->where('user_id', $user->userId)
            ->first();

        if ($tasks->isEmpty() || !$culture) {
            return response()->json([
                'success' => false,
                'message' => 'No tasks or culture data found for this user in the selected quarter.',
            ], 404);
        }

        // Calculate competence score
        $competence_score = 0;
        $total_weights = 0;

        foreach ($tasks as $task) {
            if ($task->status !== 'deferred') {
                $competence_score += $task->score;
                $total_weights += $task->weight;
            }
        }

        if ($total_weights === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Total weight is zero. Cannot compute competence score.',
            ], 422);
        }

        // Calculate scores
        if (in_array($user->classification_name, ['tmt', 'exco'])) {
            $performance_Score = round((($competence_score / $total_weights) * 60), 2);
            $culture_score = round((($culture->equity + $culture->excellence + $culture->integrity + $culture->teamwork + $culture->people) / 30 * 40), 2);
        } else {
            $performance_Score = round((($competence_score / $total_weights) * 70), 2);
            $culture_score = round(($culture->equity + $culture->excellence + $culture->integrity + $culture->teamwork + $culture->people), 2);
        }

        $overall_score = round($performance_Score + $culture_score, 2);

        // Return JSON response
        return response()->json([
            'success' => true,
            'user' => $user,
            'quarter' => $quarter,
            'tasks' => $tasks,
            'culture' => $culture,
            'competence_score' => $performance_Score,
            'culture_score' => $culture_score,
            'overall_score' => $overall_score,
        ]);
    }

    public function show_departmental_report(Request $request)
    {
        // Validate query parameter
        $validated = $request->validate([
            'quarter_id' => 'required|integer|exists:quarters,id',
            "department_id" => 'required'
        ]);

        // $departmentid = auth()->user()->department_id;
        $quarter = Quarter::find($validated['quarter_id']);

        if (!$quarter) {
            return response()->json([
                'success' => false,
                'message' => 'Quarter not found.',
            ], 404);
        }

        $department = Department::find($validated['department_id']);

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.',
            ], 404);
        }

        $users = User::where('department_id', $department->department_id)
            ->with('job')
            ->select(['userId', 'firstName', 'lastName', 'username', 'department_id', 'job_id'])
            ->orderBy('firstName', 'asc')
            ->get();

        $reportData = [];
        $totalDepartmentScore = 0;
        $totalDepartmentCultureScore = 0;
        $totalUsers = count($users);

        foreach ($users as $user) {
            $cultureScore = 0;
            $cultureData = Culture::where('user_id', $user->userId)
                ->where('quarter_id', $quarter->id)
                ->first();

            if ($cultureData) {
                $rawCultureScore = $cultureData->equity + $cultureData->excellence + $cultureData->integrity + $cultureData->teamwork + $cultureData->people;
                $cultureScore = in_array($user->classification_name, ['tmt', 'exco'])
                    ? ($rawCultureScore / 30 * 40)
                    : $rawCultureScore;
            }

            $totalUserScore = 0;
            $totalTasksScore = 0;
            $tasks = Task::where('quarter_id', $quarter->id)
                ->where('user_id', $user->userId)
                ->get();

            foreach ($tasks as $task) {
                if ($task->status !== 'deferred') {
                    $totalUserScore += $task->score;
                    $totalTasksScore += $task->weight;
                }
            }

            $userScoreOutOf70 = 0;
            if ($totalTasksScore > 0) {
                $userScoreOutOf70 = in_array($user->classification_name, ['tmt', 'exco'])
                    ? ($totalUserScore / $totalTasksScore) * 60
                    : ($totalUserScore / $totalTasksScore) * 70;
            }

            $reportData[] = [
                "user" => $user,
                "firstname" => $user->firstName,
                "lastname" => $user->lastName,
                "role" => $user->job->job_name,
                "tasks" => $tasks,
                "cultureData" => $cultureData,
                "cultureScore" => round($cultureScore, 2),
                "performanceScore" => round($userScoreOutOf70, 2),
                "totalscore" => $totalUserScore,
                "totalweight" => $totalTasksScore,
                "overallScore" => round($userScoreOutOf70 + $cultureScore, 2),
            ];

            $totalDepartmentScore += $userScoreOutOf70;
            $totalDepartmentCultureScore += $cultureScore;
        }

        $departmentAverageScore = $totalUsers > 0 ? ($totalDepartmentScore / $totalUsers) : 0;
        $averageDepartmentCultureScore = $totalUsers > 0 ? ($totalDepartmentCultureScore / $totalUsers) : 0;
        $avgOverall = $departmentAverageScore + $averageDepartmentCultureScore;

        // $svgToDisplay = $this->getSVGForResult($avgOverall, $averageDepartmentCultureScore, $departmentAverageScore);

        return response()->json([
            'success' => true,
            'department' => $department->department_name,
            'quarter' => $quarter->name,
            'report' => $reportData,
            'average_department_performance_score' => round($departmentAverageScore, 2),
            'average_department_culture_score' => round($averageDepartmentCultureScore, 2),
            'average_department_score' => round($avgOverall, 2),
            // 'svgs' => $svgToDisplay,
        ]);
    }

    public function showReport(Request $request)
    {
        $validated = $request->validate([
            'quarter_id' => 'required|exists:quarters,id',
            'min_score' => 'nullable|numeric',
            "department_id" => 'nullable|integer',
            'type' => 'required|in:all,management,department',
        ]);

        $quarter_id = $validated['quarter_id'];
        $minScore = $validated['min_score'] ?? null;
        $type = $validated['type'];
        $departmentId = $validated['department_id'];
        $quarter = Quarter::findOrFail($quarter_id);

        // Base query
        $userQuery = User::with([
            'performanceReviews' => function ($query) use ($quarter_id) {
                $query->where('quarter_id', $quarter_id);
            },
            'cultureReviews' => function ($query) use ($quarter_id) {
                $query->where('quarter_id', $quarter_id);
            },
            'classification',
            'department'
        ]);

        // Apply type-specific filters
        if ($type === 'management') {
            $userQuery->whereHas('classification', function ($q) {
                $q->whereIn('name', ['tmt', 'exco']);
            });
        } elseif ($type === 'department') {
            $userQuery->where('department_id', $departmentId);
        }

        $users = $userQuery->get();

        $reportData = [];

        foreach ($users as $user) {
            $performanceReview = $user->performanceReviews->first();
            $cultureReview = $user->cultureReviews->first();

            $performanceScore = $performanceReview ? $performanceReview->score : 0;
            $cultureScore = $cultureReview ? $cultureReview->score : 0;
            $overallScore = $performanceScore + $cultureScore;

            if ($minScore !== null && $overallScore < $minScore) {
                continue; // Skip users below the minimum score
            }

            $reportData[] = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department->name ?? null,
                'classification' => $user->classification->name ?? null,
                'performance_score' => $performanceScore,
                'culture_score' => $cultureScore,
                'overall_score' => $overallScore,
            ];
        }

        $totalUsers = count($reportData);
        $totalPerformance = array_sum(array_column($reportData, 'performance_score'));
        $totalCulture = array_sum(array_column($reportData, 'culture_score'));

        return response()->json([
            'quarter' => $quarter->only(['id', 'name']),
            'filters' => [
                'type' => $type,
                'min_score' => $minScore,
            ],
            'average_scores' => [
                'performance' => $totalUsers ? round($totalPerformance / $totalUsers, 2) : 0,
                'culture' => $totalUsers ? round($totalCulture / $totalUsers, 2) : 0,
                'overall' => $totalUsers ? round(($totalPerformance + $totalCulture) / $totalUsers, 2) : 0,
            ],
            'total_users' => $totalUsers,
            'users' => $reportData,
        ]);
    }

    // refactored
    public function showAnyReport(Request $request)
    {
        $validated = $request->validate([
            'quarter_id' => 'required|integer|exists:quarters,id',
            'department_id' => 'nullable|numeric', // Made nullable for all-departments report
            'min_score' => 'nullable|numeric|min:0|max:100',
            'filter' => 'nullable|in:all,pip,passed',
            'report_type' => 'nullable|in:departmental,all_included,managers_only' // New parameter
        ]);

        $quarter = Quarter::findOrFail($validated['quarter_id']);
        $department = isset($validated['department_id']) ? Department::findOrFail($validated['department_id']) : null;
        $minScore = $validated['min_score'] ?? null;
        $filter = $validated['filter'] ?? 'all';
        $reportType = $validated['report_type'] ?? 'departmental'; // Default to departmental

        // Base query
        $usersQuery = User::with([
            'job',
            'tasks' => function ($query) use ($quarter) {
                $query->where('quarter_id', $quarter->id)
                    ->where('status', '!=', 'deferred');
            },
            'culture' => function ($query) use ($quarter) {
                $query->where('quarter_id', $quarter->id);
            },
        ])
            ->select(['userId', 'firstName', 'lastName', 'username', 'department_id', 'job_id', 'classification_name']);

        // Apply report type filters
        switch ($reportType) {
            case 'departmental':
                if (!$department) {
                    return response()->json(['success' => false, 'message' => 'Department is required for departmental report'], 400);
                }
                $usersQuery->where('department_id', $department->department_id);
                break;

            case 'managers_only':
                $usersQuery->whereIn('classification_name', ['tmt', 'exco']);
                break;

            case 'all_included':
                // No additional filters needed - get all users
                break;
        }

        // Get and process users
        $users = $usersQuery->orderBy('firstName')->get();

        // Process user data (same as before)
        $reportData = $users->map(function ($user) use ($quarter) {
            $cultureScore = $this->calculateCultureScore($user, $quarter);
            $performanceData = $this->calculatePerformanceScore($user);
            $overallScore = $cultureScore + $performanceData['score'];

            return [
                'user_id' => $user->userId,
                'first_name' => $user->firstName,
                'last_name' => $user->lastName,
                'role' => $user->job->job_name ?? '',
                'department' => $user->department->department_name ?? '',
                'classification' => $user->classification_name,
                'culture_score' => round($cultureScore, 2),
                'performance_score' => round($performanceData['score'], 2),
                'total_score' => $performanceData['total_score'],
                'total_weight' => $performanceData['total_weight'],
                'overall_score' => round($overallScore, 2),
            ];
        });

        // Apply filters (same as before)
        if ($filter === 'pip') {
            $reportData = $reportData->filter(fn($item) => $item['overall_score'] < 70);
        } elseif ($filter === 'passed') {
            $reportData = $reportData->filter(fn($item) => $item['overall_score'] >= 70);
        }

        if ($minScore !== null) {
            $reportData = $reportData->filter(fn($item) => $item['overall_score'] >= $minScore);
        }

        // Calculate averages (same as before)
        $averages = $this->calculateDepartmentAverages($reportData);

        // Prepare meta data
        $meta = [
            'quarter' => $quarter->only(['id', 'name']),
            'filters' => [
                'min_score' => $minScore,
                'applied_filter' => $filter,
                'report_type' => $reportType,
            ],
        ];

        // Add department info only for departmental report
        if ($reportType === 'departmental' && $department) {
            $meta['department'] = $department->only(['department_id', 'department_name']);
        }

        return response()->json([
            'success' => true,
            'meta' => $meta,
            'data' => [
                'average_scores' => [
                    'performance' => $averages['performance'],
                    'culture' => $averages['culture'],
                    'overall' => $averages['overall'],
                ],
                'total_users' => $reportData->count(),
                'users' => $reportData->values(),
            ],
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    // Helper methods
    protected function calculateCultureScore(User $user, Quarter $quarter): float
    {
        $cultureData = Culture::where("user_id", $user->userId)->where("quarter_id", $quarter->id)->first();

        if (!$cultureData) {
            return 0;
        }

        $rawScore = $cultureData->equity + $cultureData->excellence
            + $cultureData->integrity + $cultureData->teamwork
            + $cultureData->people;

        return in_array($user->classification_name, ['tmt', 'exco'])
            ? ($rawScore / 30) * 40
            : $rawScore;
    }

    protected function calculatePerformanceScore(User $user): array
    {
        $totalScore = $user->tasks->sum('score');
        $totalWeight = $user->tasks->sum('weight');

        if ($totalWeight <= 0) {
            return ['score' => 0, 'total_score' => 0, 'total_weight' => 0];
        }

        $multiplier = in_array($user->classification_name, ['tmt', 'exco']) ? 60 : 70;
        $score = ($totalScore / $totalWeight) * $multiplier;

        return [
            'score' => $score,
            'total_score' => $totalScore,
            'total_weight' => $totalWeight
        ];
    }

    protected function calculateDepartmentAverages($reportData): array
    {
        $count = $reportData->count() ?: 1; // Avoid division by zero

        return [
            'performance' => round($reportData->sum('performance_score') / $count, 2),
            'culture' => round($reportData->sum('culture_score') / $count, 2),
            'overall' => round($reportData->sum('overall_score') / $count, 2),
        ];
    }
}
