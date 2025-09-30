<?php

use App\Http\Controllers\Auth\BookController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomesController;
use App\Livewire\Dashboard\Books\CreateBook;
use App\Livewire\Dashboard\Books\IndexBook;
use Illuminate\Support\Facades\Route;

// public path
Route::get("/", [HomesController::class, 'index'])->name('home');

Route::get('/about', [HomesController::class, 'about'])->name('about');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/books', IndexBook::class)->name('books.index');

    Route::get('/dashboard/books/create', CreateBook::class)->name('books.create');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
