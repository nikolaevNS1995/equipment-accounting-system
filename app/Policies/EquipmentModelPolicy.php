<?php

namespace App\Policies;

use App\Models\EquipmentModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipmentModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $allowedRoles = ['Админ', 'Инженер'];
        if ($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EquipmentModel $equipmentModel): bool
    {
        $allowedRoles = ['Админ', 'Инженер'];
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
    public function update(User $user, EquipmentModel $equipmentModel): bool
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
    public function delete(User $user, EquipmentModel $equipmentModel): bool
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
    public function restore(User $user, EquipmentModel $equipmentModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EquipmentModel $equipmentModel): bool
    {
        return false;
    }
}
