<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('frontend/Home');
});

Route::get('/help', function () {
    return inertia('frontend/Help');
});

Route::get('/contact', function () {
    return inertia('frontend/Contact');
});

Route::get('/pricing', function () {
    return inertia('frontend/Pricing');
});

Route::get('/why-ClueForge', function () {
    return inertia('frontend/WhyClueForge');
});
