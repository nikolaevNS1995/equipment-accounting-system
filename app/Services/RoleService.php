<?php

namespace App\Services;

use App\Http\Resources\Role\IndexResource;
use App\Http\Resources\Role\ShowResource;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Exception;

class RoleService
{
    protected RoleRepository $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $roles = $this->repository->getAll();
        return IndexResource::collection($roles);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $role = $this->repository->create($data);
            return new ShowResource($role);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(Role $role): ShowResource
    {
        return new ShowResource($this->repository->getById($role));
    }

    /**
     * @throws Exception
     */
    public function update(Role $role, array $data): ShowResource
    {
        try {
            $this->repository->update($role, $data);
            return new ShowResource($role);
        } catch (QueryException $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Role $role): bool
    {
        try {
            return $this->repository->delete($role);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
