<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomesController;
use Illuminate\Support\Facades\Route;

// public path
Route::get("/", [HomesController::class, 'index'])->name('home');

Route::get('/about', [HomesController::class, 'about'])->name('about');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
