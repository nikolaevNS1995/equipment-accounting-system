<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Exception;

class RoleService
{
    protected RoleRepository $repository;

    public function __construct(RoleRepository $repository)
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
    public function store(array $data): Role
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): Role
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(Role $role, array $data): Role
    {
        try {
            return $this->repository->update($role, $data);
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
