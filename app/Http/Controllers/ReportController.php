<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Quarter;
use App\Models\Department;
use App\Models\Task;
use App\Models\Culture;
use App\Models\Staff;

class ReportController extends Controller
{
    public function download_report($quarter_id)
    {
        $quarter = Quarter::find($quarter_id);

        if (!$quarter) {
            smilify('error', 'Quarter not found.');
            return redirect()->back();
        }

        $user = auth()->user();

        $staff = Staff::where('user_id', $user->id)->first();
        $tasks = Task::where('quarter_id', $quarter->id)->where('user_id', $user->id)->get();
        $culture = Culture::where('quarter_id', $quarter->id)->where('user_id', $user->id)->first();

        if ($tasks->isEmpty() || !$culture) {
            smilify('error', 'No tasks or culture data found for this quarter.');
            return redirect()->back();
        }

        $competence_score = 0;
        $total_weights = 0;

        foreach ($tasks as $task) {
            $competence_score += $task->score;
            $total_weights += $task->weight;
        }

        $culture_score = $culture->equity + $culture->excellence + $culture->integrity + $culture->teamwork + $culture->people;
        $overall_score = $culture_score + $competence_score;

        $data = [
            "user" => $user,
            "quarter" => $quarter,
            "tasks" => $tasks,
            "culture" => $culture,
            "competence_score" => $competence_score,
            "culture_score" => $culture_score,
            "overall_score" => $overall_score,
        ];

        $pdf = PDF::loadView('util.report', $data);
        return $pdf->download($quarter->name . 'report.pdf');
    }

    public function show_report(Request $request)
    {
        $validated = $request->validate([
            'quarter_id' => "required",
        ]);

        $quarter = Quarter::find($validated['quarter_id']);

        if (!$quarter) {
            smilify('error', 'Quarter not found.');
            return redirect()->back();
        }

        $user = auth()->user();

        // $staff = Staff::where('user_id', $user->id)->first();
        $tasks = Task::where('quarter_id', $quarter->id)->where('user_id', $user->userId)->get();
        $culture = Culture::where('quarter_id', $quarter->id)->where('user_id', $user->userId)->first();

        if ($tasks->isEmpty() || !$culture) {

            smilify('error', 'No tasks or culture data found for this quarter.');
            return redirect()->back();
        }

        $competence_score = 0;
        $total_weights = 0;

        foreach ($tasks as $task) {
            $competence_score += $task->score;
            $total_weights += $task->weight;
        }

        $performance_Score = number_format((($competence_score / $total_weights) * 70), 2);
        $culture_score = $culture->equity + $culture->excellence + $culture->integrity + $culture->teamwork + $culture->people;
        $overall_score = $culture_score + $performance_Score;

        $data = [
            "user" => $user,
            "quarter" => $quarter,
            "tasks" => $tasks,
            "culture" => $culture,
            "competence_score" => $performance_Score,
            "culture_score" => $culture_score,
            "overall_score" => $overall_score,
        ];

        return view('util.report-view', $data);
    }

    public function getSVGForResult($avgscore, $avgCulture, $avgPerformance)
    {
        $cultureSvg = "";
        $performanceSvg = "";
        $overallSvg = "";
        if ($avgscore >= 90) {
            $overallSvg = 'high'; // Display high score SVG
        } elseif ($avgscore >= 50) {
            $overallSvg = 'medium'; // Display medium score SVG
        } else {
            $overallSvg = 'low'; // Display low score SVG
        }

        if ($avgCulture >= 24) {
            $cultureSvg = 'high'; // Display high score SVG
        } elseif ($avgCulture >= 18) {
            $cultureSvg = 'medium'; // Display medium score SVG
        } else {
            $cultureSvg = 'low'; // Display low score SVG
        }

        if ($avgPerformance >= 65) {
            $performanceSvg = 'high'; // Display high score SVG
        } elseif ($avgPerformance >= 55) {
            $performanceSvg = 'medium'; // Display medium score SVG
        } else {
            $performanceSvg = 'low'; // Display low score SVG
        }
        return ["overall" => $overallSvg, "culture" => $cultureSvg, "performance" => $performanceSvg];
    }
    public function show_departmental_report(Request $request)
    {
        $validated = $request->validate([
            'quarter_id' => "required",
            // 'dept_id' => "required",
        ]);

        $departmentid = auth()->user()->department_id;
        $quarter = Quarter::find($validated['quarter_id']);

        if (!$quarter) {
            smilify('error', 'Quarter not found.');
            return redirect()->back();
        }

        // Fetch department and users
        $department = Department::find($departmentid);
        // $users = $department->users; // Assuming Department has a relation 'users'
        $users = User::where('department_id', $departmentid)
            ->with('job')
            ->get();

        $reportData = [];
        $totalDepartmentScore = 0;
        $totalDepartmentCultureScore = 0;
        $totalUsers = count($users);

        // Loop through each user
        foreach ($users as $user) {
            $member = $user;
            $firstname = $user->firstName;
            $lastname = $user->lastName;
            $userRole = $user->job->job_name;

            //fetch culture metrics and calculate the total score for each user
            $cultureScore = 0;
            $cultureData = Culture::where("user_id", $user->userId)->where('quarter_id', $quarter->id)->first();

            if ($cultureData != []) {
                $cultureScore = $cultureData->equity + $cultureData->excellence + $cultureData->integrity + $cultureData->teamwork + $cultureData->people;
            } else {
                $cultureScore = 0;
            }

            // Fetch tasks and calculate the total score for each user
            $totalUserScore = 0;
            $totalTasksScore = 0;
            $tasks = $user->tasks; // Assuming User has a relation 'tasks'

            foreach ($tasks as $task) {
                $totalUserScore += $task->score; // Assuming each task has a 'score'
                $totalTasksScore += $task->weight;
            }

            if ($totalTasksScore > 1) {
                // Calculate score out of 70
                $userScoreOutOf70 = ($totalUserScore / ($totalTasksScore)) * 70; // Adjust as per your score scaling
            } else {
                $userScoreOutOf70 = 0;
            }
            // Prepare data for the report
            $reportData[] = [
                "user" => $member,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'role' => $userRole, // Assuming User has a 'role' field
                "cultData" => $cultureData,
                'cultureScore' => $cultureScore,
                'performanceScore' => round($userScoreOutOf70, 2), // Rounded to 2 decimal places
                "totalscore" => $totalUserScore,
                "totalweight" => $totalTasksScore,
                "overallScore" => round(($userScoreOutOf70 + $cultureScore), 2),
            ];

            // Add to department total score
            $totalDepartmentScore += $userScoreOutOf70;
            $totalDepartmentCultureScore += $cultureScore;
        }

        // Calculate department average score
        $departmentAverageScore = $totalUsers > 0 ? ($totalDepartmentScore / $totalUsers) : 0;
        $averageDepartmentCultureScore = $totalUsers > 0 ? ($totalDepartmentCultureScore / $totalUsers) : 0;
        $avgOverall = ($departmentAverageScore + $averageDepartmentCultureScore);
        $svgToDisplay = $this->getSVGForResult($avgOverall,  $averageDepartmentCultureScore, $departmentAverageScore);

        $responseData = [
            'department' => $department->department_name,
            "quarter" => $quarter->name,
            'report' => $reportData,
            'average_department_performance_score' => round($departmentAverageScore, 2),
            'average_department_culture_score' => round($averageDepartmentCultureScore, 2),
            "average_department_score" => round($avgOverall, 2),
            "svgs" => $svgToDisplay,
        ];
        return view('util.gen_report_view', ['data' => $responseData]);
    }
}
