<?php

namespace App\Services;

use App\Http\Resources\EquipmentType\IndexResource;
use App\Http\Resources\EquipmentType\ShowResource;
use App\Models\EquipmentModel;
use App\Models\EquipmentType;
use App\Repositories\EquipmentTypeRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EquipmentTypeService
{
    protected EquipmentTypeRepository $repository;

    public function __construct(EquipmentTypeRepository $repository)
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
    public function store(array $data): EquipmentType
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): EquipmentType
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(EquipmentType $equipmentType, array $data): EquipmentType
    {
        try {
            return $this->repository->update($equipmentType, $data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(EquipmentType $equipmentType): bool
    {
        try {
            return $this->repository->delete($equipmentType);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
