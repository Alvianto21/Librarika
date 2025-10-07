<?php

namespace App\Policies;

use App\Models\Borrow;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BorrowPolicy
{
    /**
     * Determine whether the user can view any models.
     * Hanya admin dan petugas yang dapat melihat semua data peminjaman
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'petugas']);
    }

    /**
     * Determine whether the user can view the model.
     * Hanya admin dan petugas yang dapat melihat detail data peminjaman.
     * User hanya melihat datanya sedndiri.
     */
    public function view(User $user, Borrow $borrow): bool
    {
        return $user->id === $borrow->user_id || in_array($user->role, ['admin', 'petugas']);
    }

    /**
     * Determine whether the user can create models.
     * Hanya user biasa yang dapat meminjam buku
     */
    public function create(User $user): bool
    {
        return $user->role === 'user';
    }

    /**
     * Determine whether the user can update the model.
     * Hanya petugas yang dapat mengubah data pinjaman
     */
    public function update(User $user): bool
    {
        return $user->role === 'petugas';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Borrow $borrow): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Borrow $borrow): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Borrow $borrow): bool
    {
        return false;
    }
}
