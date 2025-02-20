<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CareerDevelopment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CareerDevelopmentPolicy
{
    use HandlesAuthorization;

    /**
     * Menentukan apakah pengguna dapat melihat pengembangan karir.
     */
    public function view(User $user, CareerDevelopment $careerDevelopment)
    {
        return $user->id === $careerDevelopment->user_id || $user->role === 'admin';
    }

    /**
     * Menentukan apakah pengguna dapat mengupdate pengembangan karir.
     */
    public function update(User $user, CareerDevelopment $careerDevelopment)
    {
        return $user->role === 'admin';
    }

    /**
     * Menentukan apakah pengguna dapat menghapus pengembangan karir.
     */
    public function delete(User $user, CareerDevelopment $careerDevelopment)
    {
        return $user->role === 'admin';
    }
}
