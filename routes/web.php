<?php

use App\Http\Controllers\HomesController;
use Illuminate\Support\Facades\Route;

// public path
Route::get("/", [HomesController::class, 'index']);

Route::get('/about', [HomesController::class, 'about']);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
