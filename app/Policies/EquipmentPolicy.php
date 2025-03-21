<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $allowedRoles = ['Админ', 'Инженер', 'Сотрудник'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equipment $equipment): bool
    {
        $allowedRoles = ['Админ', 'Инженер', 'Сотрудник'];
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
        $allowedRoles = ['Админ', 'Инженер'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipment $equipment): bool
    {
        $allowedRoles = ['Админ', 'Инженер'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Equipment $equipment): bool
    {
        $allowedRoles = ['Админ', 'Инженер'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Equipment $equipment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Equipment $equipment): bool
    {
        return false;
    }
}
