<?php

namespace App\Services;

use App\Models\FurnitureType;
use App\Repositories\FurnitureTypeRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class FurnitureTypeService
{
    protected FurnitureTypeRepository $repository;

    public function __construct(FurnitureTypeRepository $repository)
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
    public function store(array $data): FurnitureType
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): FurnitureType
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(FurnitureType $furnitureType, array $data): FurnitureType
    {
        try {
            return $this->repository->update($furnitureType, $data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(FurnitureType $furnitureType): bool
    {
        try {
            return $this->repository->delete($furnitureType);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
