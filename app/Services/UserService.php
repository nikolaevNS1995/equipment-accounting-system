<?php

namespace App\Services;

use App\Http\Resources\User\IndexResource;
use App\Http\Resources\User\ShowResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
    public function index(): AnonymousResourceCollection
    {
        $users = $this->repository->getAll();
        return IndexResource::collection($users);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $data['password'] = Hash::make($data['password']);
            $roles = $data['roles'];
            unset($data['roles']);
            DB::beginTransaction();
            $user = $this->repository->create($data);
            $this->repository->addRole($user, $roles);
            DB::commit();
            return new ShowResource($user);
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function show(User $user): ShowResource
    {
        return new ShowResource($this->repository->getById($user));
    }

    /**
     * @throws Exception
     */
    public function update(User $user, array $data): ShowResource
    {
        try {
            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            }
            $roles = $data['roles'];
            unset($data['roles']);
            DB::beginTransaction();
            $this->repository->update($user, $data);
            $this->repository->editRole($user, $roles);
            DB::commit();
            return new ShowResource($user);
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
            $this->repository->removeRole($user);
            $this->repository->delete($user);
            DB::commit();
            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
