<?php

namespace App\Services;

use App\Http\Resources\EquipmentType\IndexResource;
use App\Http\Resources\EquipmentType\ShowResource;
use App\Models\EquipmentModel;
use App\Models\EquipmentType;
use App\Repositories\EquipmentTypeRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EquipmentTypeService
{
    protected EquipmentTypeRepository $repository;

    public function __construct(EquipmentTypeRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $equipmentTypes = $this->repository->getAll();
        return IndexResource::collection($equipmentTypes);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $equipmentType = $this->repository->create($data);
            return new ShowResource($equipmentType);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(EquipmentType $equipmentType): ShowResource
    {
        return new ShowResource($this->repository->getById($equipmentType));
    }

    /**
     * @throws Exception
     */
    public function update(EquipmentType $equipmentType, array $data): ShowResource
    {
        try {
            $this->repository->update($equipmentType, $data);
            return new ShowResource($equipmentType);
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
