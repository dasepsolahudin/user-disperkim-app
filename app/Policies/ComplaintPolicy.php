<?php

namespace App\Policies;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Complaint $complaint): bool
    {
        // Pengguna hanya boleh melihat pengaduan miliknya sendiri.
        return $user->id === $complaint->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Complaint $complaint): bool
    {
        // Pengguna hanya boleh memperbarui pengaduan miliknya sendiri.
        return $user->id === $complaint->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Complaint $complaint): bool
    {
        // Pengguna hanya boleh menghapus pengaduan miliknya sendiri.
        return $user->id === $complaint->user_id;
    }
}