<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// FRONTEND ROUTES
Route::prefix('/')->group(function () {
    Route::get('/', function () { return inertia('frontend/Home'); })->name('home');
    Route::get('/help', function () { return inertia('frontend/Help'); })->name('help');
    Route::get('/contact', function () { return inertia('frontend/Contact'); })->name('contact');
    Route::get('/pricing', function () { return inertia('frontend/Pricing'); })->name('pricing');
    Route::get('/why-ClueForge', function () { return inertia('frontend/WhyClueForge'); })->name('whyClueForge');
});

//  AUTH ROUTES
// todo: redirect when already logged in.
Route::prefix('/')->group(function () {
    Route::get('/register', function () { return inertia('frontend/auth/Register'); })->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', function () { return inertia('frontend/auth/Login'); })->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

//  APP ROUTES
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/app', function () { return inertia('backend/Dashboard'); })->name('app.dashboard');
});

// ADMIN ROUTES
Route::middleware(['auth', 'verified'])->prefix('/admin')->group(function () {
    Route::get('/', function () { return inertia('admin/Dashboard'); })->name('admin.dashboard');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::delete('/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulkDelete');
        Route::post('/bulk-restore', [UserController::class, 'bulkRestore'])->name('users.bulkRestore');
    });
});




