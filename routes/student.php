<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\AuthController;
use App\Http\Controllers\Student\CBTController;
use App\Http\Controllers\Student\DashboardController;

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register student routes for your application.
|
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.show');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('reset-password', [AuthController::class, 'resetPassword']);




// Student Protected Routes (requires authentication)
Route::middleware(['auth:student'])->group(function () {
    // CBT Routes (accessible during active test)
    Route::prefix('cbt')->name('cbt.')->group(function () {
        Route::get('/', [CBTController::class, 'index'])->name('index');
        Route::get('{type}/{subjectId}/instructions', [CBTController::class, 'instructions'])->name('instructions');
        Route::get('{type}/{subject_id}', [CBTController::class, 'startTest'])->name('start');
        Route::post('/ongoing/update/option', [CBTController::class, 'updateOption'])->name('update-option');
        Route::get('/{id}', [CBTController::class, 'show'])->name('show');
        Route::get('{type}/{subjectId}/result', [CBTController::class, 'result'])->name('result');
        Route::post('/ongoing/submit/end', [CBTController::class, 'submit'])->name('submit');
    });

    // Routes restricted during active CBT test
    Route::middleware(['cbt'])->group(function () {
        // Logout route
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile Management
        Route::get('profile', [AuthController::class, 'showProfile'])->name('profile');
        Route::put('profile', [AuthController::class, 'updateProfile']);
        Route::put('change-password', [AuthController::class, 'changePassword'])->name('change-password');

        // Results Routes
        Route::prefix('results')->name('results.')->group(function () {
            Route::get('/', [DashboardController::class, 'result'])->name('index');
            Route::get('/{id}', [DashboardController::class, 'show'])->name('show');
        });

        // Documents Routes
        Route::prefix('documents')->name('documents.')->group(function () {
            Route::get('/', [DashboardController::class, 'documents'])->name('index');
            Route::get('/{id}', [DashboardController::class, 'show'])->name('show');
            Route::post('/upload', [DashboardController::class, 'upload'])->name('upload');
        });

        // Settings Routes
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/account', [DashboardController::class, 'account'])->name('account');
            Route::put('/account', [DashboardController::class, 'updateAccount']);
            Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
            Route::put('/notifications', [DashboardController::class, 'updateNotifications']);
        });

        // Tools Routes
        Route::prefix('tools')->name('tools.')->group(function () {
            Route::get('/calculator', [DashboardController::class, 'calculator'])->name('calculator');
            Route::get('/notes', [DashboardController::class, 'notes'])->name('notes');
            Route::post('/notes', [DashboardController::class, 'saveNotes']);
            Route::get('/calendar', [DashboardController::class, 'calendar'])->name('calendar');
        });

        // Help Route
        Route::get('/help', [DashboardController::class, 'help'])->name('help');
    });
});
