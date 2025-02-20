<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Performance;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerformancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the performance report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Performance $performance)
    {
        return $user->id === $performance->user_id; // Hanya pengguna yang membuat laporan yang bisa mengedit
    }

    /**
     * Determine whether the user can delete the performance report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Performance $performance)
    {
        return $user->id === $performance->user_id; // Hanya pengguna yang membuat laporan yang bisa menghapus
    }
}
