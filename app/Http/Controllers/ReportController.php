<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Quarter;
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

        return view('util.report-view', $data);
    }
}
