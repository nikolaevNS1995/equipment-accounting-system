<?php

namespace App\Services;

use App\Http\Resources\EquipmentModel\IndexResource;
use App\Http\Resources\EquipmentModel\ShowResource;
use App\Models\EquipmentModel;
use App\Repositories\EquipmentModelRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EquipmentModelService
{
    protected EquipmentModelRepository $repository;

    public function __construct(EquipmentModelRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $equipmentModels = $this->repository->getAll();
        return IndexResource::collection($equipmentModels);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $equipmentModel = $this->repository->create($data);
            return new ShowResource($equipmentModel);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function show(EquipmentModel $equipmentModel): ShowResource
    {
        return new ShowResource($this->repository->getById($equipmentModel));
    }

    /**
     * @throws Exception
     */
    public function update(EquipmentModel $equipmentModel, array $data): ShowResource
    {
        try {
            $this->repository->update($equipmentModel, $data);
            return new ShowResource($equipmentModel);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(EquipmentModel $equipmentModel): ?bool
    {
        try {
            return $this->repository->delete($equipmentModel);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
