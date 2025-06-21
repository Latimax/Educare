<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/admission', [HomeController::class, 'admission'])->name('admission');

Route::get('/classes', [HomeController::class, 'classes'])->name('classes');

Route::get('/faq', [HomeController::class, 'faqs'])->name('faqs');

Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

Route::get('/special-class', [HomeController::class, 'specialClass'])->name('special.class');

Route::get('/teachers', [HomeController::class, 'teachers'])->name('teachers');

Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');

Route::get('/login', function () {
    return view('welcome');
})->name('login');
