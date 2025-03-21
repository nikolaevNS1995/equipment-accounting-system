<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class UserRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('users:all', function () {
            return User::with('role')->get();
        });
    }

    public function create(User $user): User
    {
        $user->load('role');
        Cache::forget('users:all');
        Cache::put('users:' . $user->id, $user);
        return $user;
    }

    public function getById(int $id): User
    {
        return Cache::rememberForever('users:' . $id, function () use ($id) {
            return User::with('role')->findOrFail($id);
        });
    }

    public function update(User $user): User
    {
        $user->load('role');
        Cache::forget('users:all');
        Cache::put('users:' . $user->id, $user);
        return $user;
    }

    public function delete(User $user): ?bool
    {
        $user->role()->detach();
        Cache::forget('users:all');
        Cache::forget('users:' . $user->id);
        return $user->delete();
    }
}
