<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RememberPassController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Route::get('/register', [LoginController::class, 'register'])->name('registrasi');

    Route::post('/register', [LoginController::class, 'store'])->name('register');

    Route::get('/login', [LoginController::class, 'login'])->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

    Route::get('/forgot-password', [RememberPassController::class, 'sendLinkReset'])->name('password.request');

    Route::post('/forgot-password', [RememberPassController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [RememberPassController::class, 'resetForm'])->name('password.reset');

    Route::post('/reset-password', [RememberPassController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [VerifyController::class, 'sendEmail'])->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('/email/verification-notification', [VerifyController::class, 'resendEmail'])->middleware('throttle:6,1')->name('verification.send');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
