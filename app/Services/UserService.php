<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * @throws Exception
     */
    public function store(array $data): User
    {
        try {
            $data['password'] = Hash::make($data['password']);
            $roles = $data['roles'];
            unset($data['roles']);
            DB::beginTransaction();
            $user = User::create($data);
            $user->role()->attach($roles);
            $user = $this->repository->create($user);
            DB::commit();
            return $user;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): User
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(User $user, array $data): User
    {
        try {
            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            }
            $roles = $data['roles'];
            unset($data['roles']);
            DB::beginTransaction();
            $user->update($data);
            $user->role()->sync($roles);
            $user = $this->repository->update($user);
            DB::commit();
            return $user;
        } catch (QueryException $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(User $user): bool
    {
        try {
            DB::beginTransaction();
            $this->repository->delete($user);
            DB::commit();
            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
