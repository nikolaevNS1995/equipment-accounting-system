<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function getById(User $user): User
    {
        return $user;
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): ?bool
    {
        return $user->delete();
    }

    public function addRole(User $user, array $roles): void
    {
        $user->role()->attach($roles);
    }

    public function editRole(User $user, array $roles): void
    {
        $user->role()->sync($roles);
    }

    public function removeRole(User $user): void
    {
        $user->role()->detach();
    }
}
