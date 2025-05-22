<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CultureController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubdepartmentController;
use App\Http\Controllers\StaffSubmissionsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\EquitySkillsController;
use App\Http\Controllers\PeopleSkillsController;
use App\Http\Controllers\TeamworkSkillsController;
use App\Http\Controllers\ExcellenceSkillsController;
use App\Http\Controllers\IntegritySkillsController;
use App\Http\Controllers\QuarterController;
use App\Http\Controllers\AttachmentsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PasswordResetController;
use App\Models\Quarter;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get("test/fileuploadsize", function () {
    dd(phpinfo());
});

Route::get('/', function () {
    return view('welcome');
});

Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name("pwdreset");
Route::get('/forgotten-password', [PasswordResetController::class, 'forgottenPassword'])->name("forgotten.password");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $data = Quarter::get();
        // where('is_active', false)->get();
        return view('dashboard', ["data" => $data]);
    })->name('dashboard');
});

Route::resource("staff", StaffController::class)->middleware('auth');
Route::resource("quarter", QuarterController::class)->middleware('auth');


Route::middleware(['auth', 'staff'])->group(function () {
    // Route::resource("quarter", QuarterController::class);

    Route::resource("culture", CultureController::class);

    Route::get('culture/assessment/{id}', [CultureController::class, 'assess'])->name('culture.assessment');

    Route::resource("tasks", TaskController::class);
    Route::post("tasks/differ/{id}", [TaskController::class, "differTask"])->name('tasks.differ');

    Route::get("download/report/{id}", [ReportController::class, 'download_report'])->name("reports.download");

    Route::post("show/report", [ReportController::class, 'show_report'])->name("reports.show");

    // ############################
    Route::post("show/compreport", [ReportController::class, 'show_overall_report'])->name("compreports.show");
    Route::post("show/mgtreport", [ReportController::class, 'show_management_report'])->name("mgtreports.show");

    Route::post("show/deptreport", [ReportController::class, 'show_departmental_report'])->name("deptreports.show");

    Route::resource("attachments", AttachmentsController::class);
    Route::get("task/attachments/{id}", [AttachmentsController::class, "showTaskAttachments"])->name('task.attachments');

    Route::patch("task.score/{task}", [TaskController::class, "score"])->name("task.score");
    // Route::patch("task.score/{task}", [TaskController::class, "score"])->name("task.score");

    Route::resource("tasks.comments", CommentsController::class);
    // Route::get("task/attachments/{id}", [AttachmentsController::class, "comments"])->name('subtask.attachments');


    Route::resource("equity", EquitySkillsController::class);
    Route::resource("people", PeopleSkillsController::class);
    Route::resource("teamwork", TeamworkSkillsController::class);
    Route::resource("excellence", ExcellenceSkillsController::class);
    Route::resource("integrity", IntegritySkillsController::class);

    Route::post("equity/add", [EquitySkillsController::class, "addequity"])->name('equity.add');

    Route::resource('history', HistoryController::class);

    Route::get('tasks/submitted', [TaskController::class, 'submitted'])->name('tasks.submitted');
    // [TaskController::class, 'submitted'])->name('tasks.submitted');

    Route::resource("department", DepartmentController::class);

    Route::resource("department.subdepartment", SubdepartmentController::class);

    Route::resource("tasks.subtasks", SubtaskController::class);
    Route::post("subtasks/submit/{id}", [SubtaskController::class, "submit"])->name("subtasks.submit");

    Route::get("task/submit/{id}", [TaskController::class, "submit"]);


    Route::resource("supervisees", StaffSubmissionsController::class);

    // Route::post('tasks/subtasks/approve/{id}', [TaskController::class, 'approve'])->name('tasks.subtasks.approve');
});




// Route::resource("supervisees", StaffSubmissionsController::class);

// Route::resource("culture", CultureController::class);

// Route::resource("tasks", TaskController::class);

// Route::get('tasks/supervised', [TaskController::class, 'supervised'])->name('tasks.supervised');
// // [TaskController::class, 'submitted'])->name('tasks.submitted');

// Route::resource("department", DepartmentController::class);

// Route::resource("department.subdepartment", SubdepartmentController::class);

// Route::resource("tasks.subtasks", SubtaskController::class);

// Route::get("tasks/subtasks/submit/{id}",[SubtaskController::class, "submit"]);

// Route::post('tasks/subtasks/approve/{id}', [TaskController::class, 'approve'])->name('tasks.subtasks.approve');
