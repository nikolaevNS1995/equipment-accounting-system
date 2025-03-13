<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class RoleRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('roles:all', function () {
            return Role::all();
        });
    }

    public function create(array $data): Role
    {
        $role = Role::create($data);
        Cache::forget('roles:all');
        Cache::put('roles:' . $role->id, $role);
        return $role;
    }

    public function getById(int $id): Role
    {
        return Cache::rememberForever('roles:' . $id, function () use ($id) {
            return Role::findOrFail($id);
        });
    }

    public function update(Role $role, array $data): Role
    {
        $role->update($data);
        Cache::forget('roles:all');
        Cache::put('roles:' . $role->id, $role);
        return $role;
    }

    public function delete(Role $role): ?bool
    {
        Cache::forget('roles:all');
        Cache::forget('roles:' . $role->id);
        return $role->delete();
    }
}
