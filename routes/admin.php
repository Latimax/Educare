<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CbtConfigController;
use App\Http\Controllers\Admin\CbtQuestionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamConfigController;
use App\Http\Controllers\Admin\ExamQuestionController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ResultCommentController;
use App\Http\Controllers\Admin\SchoolInfoController;
use App\Http\Controllers\Admin\SchoolLevelController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
|
*/

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('reset-password', [AuthController::class, 'resetPassword']);




// Admin Protected Routes (requires authentication)
Route::middleware(['auth:admin'])->group(function () {
    // Logout route
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Site Info Management
    Route::resource('school-info', SchoolInfoController::class);

    //School Levels
    Route::resource('levels', SchoolLevelController::class);

    //School Class Lists
    Route::resource('classes', SchoolClassController::class);

    //School Staff Management
    Route::resource('staffs', StaffController::class);

    //School Student Management
    Route::resource('students', StudentController::class);

    // Show children for a specific parent ID
    Route::get('students/view/children/{id?}', [StudentController::class, 'showChildren'])->name('students.children');

    Route::get('students/view/classes/{id?}', [StudentController::class, 'showClasses'])->name('students.classes');
    // Show all classes if no ID is provided
    Route::get('students/view/classes', [StudentController::class, 'showClasses'])->name('students.classes.all');

    Route::get('students/view/levels', [StudentController::class, 'showLevels'])->name('students.levels');

    //Search students by name
    Route::get('students/byname/search', [StudentController::class, 'searchByName'])
        ->name('students.byname.search');


    //Parent Resource
    Route::resource('parents', ParentController::class);

    //Subject Resource
    Route::resource('subjects', SubjectController::class);
    Route::get('subjects/level/{level}', [SubjectController::class, 'index'])->name('subjects.level');

    //Exam Questions Resource
    Route::resource('examquestions', ExamQuestionController::class);
    Route::get('examquestions/classes/{level}', [ExamQuestionController::class, 'getClasses'])->name('examquestions.classes');
    Route::get('examquestions/level/{level}', [ExamQuestionController::class, 'index'])->name('examquestions.level');
    Route::get('examquestions/subjects/{level}/{classId}', [ExamQuestionController::class, 'getSubjects'])->name('examquestions.subjects');
    Route::post('examquestions/question/upload-image', [ExamQuestionController::class, 'uploadImage'])->name('examquestions.upload-image');


    //admin.examquestions.subjects.store
    Route::put('examquestions/subjects/save', [ExamQuestionController::class, 'save'])->name('examquestions.subjects.save');

    Route::get('examquestions/subjects/{subjectId}/{classId}/content', [ExamQuestionController::class, 'getContent'])->name('examquestions.subjects.content');
    Route::get('examquestions/classes/{classId}/name', [ExamQuestionController::class, 'getClassName'])->name('examquestions.classes.name');


    //CBT Questions Resource
    Route::resource('cbtquestions', CbtQuestionController::class);
    Route::get('cbtquestions/classes/{level}', [CbtQuestionController::class, 'getClasses'])->name('cbtquestions.classes');
    Route::get('cbtquestions/level/{level}', [CbtQuestionController::class, 'index'])->name('cbtquestions.level');
    Route::get('cbtquestions/subjects/{level}/{classId}', [CbtQuestionController::class, 'getSubjects'])->name('cbtquestions.subjects');
    Route::post('cbtquestions/question/upload-image', [CbtQuestionController::class, 'uploadImage'])->name('cbtquestions.upload-image');


    //admin.cbtquestions.subjects.store
    Route::put('cbtquestions/subjects/save', [CbtQuestionController::class, 'save'])->name('cbtquestions.subjects.save');

    Route::get('cbtquestions/subjects/{subjectId}/{classId}/content', [CbtQuestionController::class, 'getContent'])->name('cbtquestions.subjects.content');
    Route::get('cbtquestions/classes/{classId}/name', [CbtQuestionController::class, 'getClassName'])->name('cbtquestions.classes.name');



    //Payment Resource
    Route::resource('payments', PaymentController::class);

    //CBT Setup Resource
    Route::resource('cbtconfig', CbtConfigController::class);

    Route::post('cbtconfig/subject-toggle', [CbtConfigController::class, 'toggleSubject'])->name('cbtconfig.subject-toggle');
    Route::put('cbtconfig/update/scores', [CbtConfigController::class, 'updateScores'])->name('cbtconfig.updatescore');

    //Result Grade Resource
    Route::resource('grades', GradeController::class);

    //Result Comment Resource
    Route::resource('resultcomments', ResultCommentController::class);


    // Profile Management
    Route::get('profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('profile', [AuthController::class, 'updateProfile']);
    Route::put('change-password', [AuthController::class, 'changePassword'])->name('change-password');
});
