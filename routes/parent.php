<?php

use App\Http\Controllers\Parent\AuthController;
use App\Http\Controllers\Parent\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// Parent Protected Routes (requires authentication)
Route::middleware(['auth:parent'])->group(function () {
    // Logout route
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //Parent child managementent
    Route::get('children/index', [DashboardController::class, 'showChildren'])->name('children.index');
    Route::get('children/{id}/show', [DashboardController::class, 'viewChild'])->name('children.show');

    //Children results
    Route::get('children/result/class/{id?}', [DashboardController::class, 'result'])->name('children.result');
    Route::get('children/result/print/{studentId}', [DashboardController::class, 'print'])->name('children.result.print');
    Route::get('children/result/download/{studentId}', [DashboardController::class, 'downloadPDF'])->name('children.result.download');


    //Payment management
     Route::get('payments/index', [DashboardController::class, 'payments'])->name('payments.index');
     Route::get('payments/{id}/print', [DashboardController::class, 'printReceipt'])->name('payments.print');


     // Profile Management
    Route::get('profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('change-password', [AuthController::class, 'changePassword'])->name('password.update');
});
