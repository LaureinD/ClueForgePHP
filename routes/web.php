<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('frontend/Home');
})->name('home');

Route::get('/help', function () {
    return inertia('frontend/Help');
})->name('help');

Route::get('/contact', function () {
    return inertia('frontend/Contact');
})->name('contact');

Route::get('/pricing', function () {
    return inertia('frontend/Pricing');
})->name('pricing');

Route::get('/why-ClueForge', function () {
    return inertia('frontend/WhyClueForge');
})->name('whyClueForge');

Route::get('/login', function () {
    return inertia('frontend/auth/Login');
})->name('auth.login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function() {
    return inertia('frontend/auth/Register');
})->name('auth.register');

Route::post('/register', [AuthController::class, 'register']);

route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/app', function () {
    return inertia('backend/Dashboard');
})->name('app.dashboard');

Route::get('/admin', function () {
    return inertia('admin/Dashboard');
})->name('admin.dashboard');
