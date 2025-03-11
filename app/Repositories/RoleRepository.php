<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository
{
    public function getAll(): Collection
    {
        return Role::all();
    }

    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function getById(Role $role): Role
    {
        return $role;
    }

    public function update(Role $role, array $data): bool
    {
        return $role->update($data);
    }

    public function delete(Role $role): ?bool
    {
        return $role->delete();
    }
}
