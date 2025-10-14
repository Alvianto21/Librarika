<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomesController;
use App\Http\Controllers\ReportExportController;
use App\Livewire\Dashboard\Books\CreateBook;
use App\Livewire\Dashboard\Books\EditBook;
use App\Livewire\Dashboard\Books\IndexBook;
use App\Livewire\Dashboard\Books\ShowBook;
use App\Livewire\Dashboard\Borrows\EditBorrow;
use App\Livewire\Dashboard\Borrows\IndexBorrow;
use App\Livewire\Dashboard\Borrows\ShowBorrow;
use App\Livewire\Dashboard\Borrows\UserBorrow;
use App\Livewire\Dashboard\Borrows\UserBorrowCreate;
use App\Livewire\Dashboard\Borrows\UserBorrowInfo;
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

Route::middleware(['auth', 'verified', 'role:petugas,admin'])->group(function () {
    Route::get('/dashboard/borrow', IndexBorrow::class)->name('borrow.index');

    Route::get('/dashboard/borrow/{borrow:kode_pinjam}', ShowBorrow::class)->name('borrow.show');

    Route::get('/dashboard/borrow/{borrow:kode_pinjam}/edit', EditBorrow::class)->name('borrow.edit');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard/borrow/report/xlsx', [ReportExportController::class, 'exportExcel'])->name('borrow.report.excel');

    Route::get('/dashboard/borrow/report/pdf', [ReportExportController::class, 'exportPDF'])->name('borrow.report.pdf');
});

Route::middleware(['auth', 'verified', 'role:user'])->prefix('users')->group(function () {
    Route::get('/borrows', UserBorrow::class)->name('users.borrows');

    Route::get('/borrows/create', UserBorrowCreate::class)->name('users.borrow.create');

    Route::get('/borrows/{borrow:kode_pinjam}', UserBorrowInfo::class)->name('users.borrow.info');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
