<?php

namespace App\Policies;

use App\Models\Cabinet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CabinetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $allowedRoles = ['Админ', 'Инженер', 'Сотрудник'];
        if($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cabinet $cabinet): bool
    {
        $allowedRoles = ['Админ', 'Инженер', 'Сотрудник'];
        if($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
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
        if($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cabinet $cabinet): bool
    {
        $allowedRoles = ['Админ'];
        if($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cabinet $cabinet): bool
    {
        $allowedRoles = ['Админ'];
        if($user->role->pluck('title')->intersect($allowedRoles)->isNotEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Cabinet $cabinet): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Cabinet $cabinet): bool
    {
        return false;
    }
}
