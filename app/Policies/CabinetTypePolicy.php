<?php

namespace App\Policies;

use App\Models\CabinetType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CabinetTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $allowedRoles = ['Админ'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CabinetType $cabinetType): bool
    {
        $allowedRoles = ['Админ'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $allowedRoles = ['Админ'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CabinetType $cabinetType): bool
    {
        $allowedRoles = ['Админ'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CabinetType $cabinetType): bool
    {
        $allowedRoles = ['Админ'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CabinetType $cabinetType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CabinetType $cabinetType): bool
    {
        return false;
    }
}
