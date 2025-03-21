<?php

namespace App\Services;

use App\Models\Building;
use App\Repositories\BuildingRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Exception;

class BuildingService
{
    protected BuildingRepository $repository;

    public function __construct(BuildingRepository $repository)
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
    public function store(array $data): Building
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): Building
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(Building $building, array $data): Building
    {
        try {
            return $this->repository->update($building, $data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Building $building): bool
    {
        try {
            return $this->repository->delete($building);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
