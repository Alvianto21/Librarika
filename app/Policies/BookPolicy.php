<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    /**
     * Determine whether the user can view any models.
     * Semua level user dapat melihat daftar buku
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'petugas', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     * Semua level user dapat melihat detail buku
     */
    public function view(User $user, Book $book): bool
    {
        return in_array($user->role, ['admin', 'petugas', 'user']);
    }

    /**
     * Determine whether the user can create models.
     * Hanya petugas yang dapat menambah data buku
     */
    public function create(User $user): bool
    {
        return $user->role === 'petugas';
    }

    /**
     * Determine whether the user can update the model.
     * Hanya peyugas yang dapat mengubah data buku
     */
    public function update(User $user): bool
    {
        return $user->role === 'petugas';
    }

    /**
     * Determine whether the user can delete the model.
     * Hanya petugas yang dapat menghapus data buku
     */
    public function delete(User $user): bool
    {
        return $user->role === 'petugas';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Book $book): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Book $book): bool
    {
        return false;
    }
}
