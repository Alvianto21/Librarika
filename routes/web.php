<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomesController;
use App\Livewire\Dashboard\Books\CreateBook;
use App\Livewire\Dashboard\Books\EditBook;
use App\Livewire\Dashboard\Books\IndexBook;
use App\Livewire\Dashboard\Books\ShowBook;
use Illuminate\Support\Facades\Route;

// public path
Route::get("/", [HomesController::class, 'index'])->name('home');

Route::get('/about', [HomesController::class, 'about'])->name('about');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/books', IndexBook::class)->name('books.index');

    Route::get('/dashboard/books/create', CreateBook::class)->name('books.create')->middleware('role:petugas');

    route::get('/dashboard/books/{book:slug}', ShowBook::class)->name('books.show');

    Route::get('/dashboard/books/{book:slug}/edit', EditBook::class)->name('book.edit')->middleware('role:petugas');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
