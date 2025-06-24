<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\AuthController;
use App\Http\Controllers\Staff\CbtQuestionController;
use App\Http\Controllers\Staff\DashboardController;
use App\Http\Controllers\Staff\ExamQuestionController;
use App\Http\Controllers\Staff\ResultController;
use App\Http\Controllers\Staff\StudentController;
use App\Http\Controllers\Staff\StudentScoresController;
use App\Http\Controllers\Staff\SubjectController;

/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
|
| Here is where you can register staff routes for your application.
|
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('reset-password', [AuthController::class, 'resetPassword']);




// Staff Protected Routes (requires authentication)
Route::middleware(['auth:staff'])->group(function () {
    // Logout route
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //School Student Management
    Route::resource('students', StudentController::class);


    // Show children for a specific parent ID
    Route::get('students/view/children/{id?}', [StudentController::class, 'showChildren'])->name('students.children');

     // Show Students for a specific Class ID
    Route::get('students/view/class/{id?}', [StudentController::class, 'students'])->name('students.filter');

    Route::get('students/view/classes/{id?}', [StudentController::class, 'showClasses'])->name('students.classes');
    // Show all classes if no ID is provided
    Route::get('students/view/classes', [StudentController::class, 'showClasses'])->name('students.classes.all');

    Route::get('students/view/levels', [StudentController::class, 'showLevels'])->name('students.levels');

    //Search students by name
    Route::get('students/byname/search', [StudentController::class, 'searchByName'])
        ->name('students.byname.search');



    //Subject Resource
    Route::resource('subjects', SubjectController::class);
    Route::get('subjects/level/{level}', [SubjectController::class, 'index'])->name('subjects.level');

    //Exam Questions Resource
    Route::resource('examquestions', ExamQuestionController::class);
    Route::get('examquestions/classes/{level}', [ExamQuestionController::class, 'getClasses'])->name('examquestions.classes');
    Route::get('examquestions/level/{level}', [ExamQuestionController::class, 'index'])->name('examquestions.level');
    Route::get('examquestions/subjects/{level}/{classId}', [ExamQuestionController::class, 'getSubjects'])->name('examquestions.subjects');
    Route::post('examquestions/question/upload-image', [ExamQuestionController::class, 'uploadImage'])->name('examquestions.upload-image');


    //staff.examquestions.subjects.store
    Route::put('examquestions/subjects/save', [ExamQuestionController::class, 'save'])->name('examquestions.subjects.save');

    Route::get('examquestions/subjects/{subjectId}/{classId}/content', [ExamQuestionController::class, 'getContent'])->name('examquestions.subjects.content');
    Route::get('examquestions/classes/{classId}/name', [ExamQuestionController::class, 'getClassName'])->name('examquestions.classes.name');


    //CBT Questions Resource
    Route::resource('cbtquestions', CbtQuestionController::class);
    Route::get('cbtquestions/{subjectId}/{classId}/create', [CbtQuestionController::class, 'create'])->name('cbtquestions.subjects.create');

    Route::get('cbtquestions/classes/{level}', [CbtQuestionController::class, 'getClasses'])->name('cbtquestions.classes');
    Route::get('cbtquestions/level/{level}', [CbtQuestionController::class, 'index'])->name('cbtquestions.level');
   Route::post('cbtquestions/question/upload-image', [CbtQuestionController::class, 'uploadImage'])->name('cbtquestions.upload-image');
    Route::get('ctbquestions/subjects/{subjectId}/{className}/view', [CbtQuestionController::class, 'view'])->name('cbtquestions.subjects.view');

    //staff.cbtquestions.subjects.update
    Route::put('cbtquestions/subjects/save', [CbtQuestionController::class, 'save'])->name('cbtquestions.subjects.save');

    //staff.cbtquestions.subjects.new
    Route::put('cbtquestions/subjects/create/new', [CbtQuestionController::class, 'saveNew'])->name('cbtquestions.subjects.save.new');

    Route::get('cbtquestions/subjects/{subjectId}/{classId}/content', [CbtQuestionController::class, 'getContent'])->name('cbtquestions.subjects.content');
    Route::get('cbtquestions/classes/{classId}/name', [CbtQuestionController::class, 'getClassName'])->name('cbtquestions.classes.name');



    //Student Scores Resource
    Route::resource('studentscores', StudentScoresController::class);
    Route::post('studentscores/query', [StudentScoresController::class, 'getScores'])->name('studentscores.query');
    Route::get('studentscores/getclasses/{level_id}', [StudentScoresController::class, 'getClasses'])->name('studentscores.getclasses');
   Route::get('studentscores/subjects/{level}/{classId}', [StudentScoresController::class, 'getSubjects'])->name('studentscores.subjects');
   Route::get('studentscores/subjects/{subjectId}/{classId}/scores', [StudentScoresController::class, 'studentScores'])->name('studentscores.subjects.scores');
   Route::post('studentscores/update', [StudentScoresController::class, 'studentScoresUpdate'])->name('studentscores.scores.update');

    //Student Result Resource
    Route::resource('studentresults', ResultController::class);
    Route::get('studentresults/compute/create/{class?}', [ResultController::class, 'createNew'])->name('studentresults.compute.create');
    Route::get('studentresults/view/classes/{id?}', [ ResultController::class, 'showClasses'])->name('studentresults.classes');
    Route::get('studentresults/print/{studentId}', [ResultController::class, 'print'])->name('studentresults.print');
    Route::get('studentresults/download/{studentId}', [ResultController::class, 'downloadPDF'])->name('studentresults.download');

    //Fetch a specific student scores
    Route::get('studentresults/compute/getscores/{studentId}', [ResultController::class, 'getScores'])->name('studentresults.getscores');

    //Rank a specific class result
    Route::get('studentresults/compute/rankall/{classId}', [ResultController::class, 'rankAll'])->name('studentresults.rankall');


    // Show Students bResults for a specific Class ID
    Route::get('studentresults/view/class/{id?}', [ResultController::class, 'students'])->name('studentresults.filter');



    // Profile Management
    Route::get('profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('profile', [AuthController::class, 'updateProfile']);
    Route::put('change-password', [AuthController::class, 'changePassword'])->name('change-password');
});
