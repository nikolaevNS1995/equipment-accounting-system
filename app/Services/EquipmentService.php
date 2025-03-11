<?php

namespace App\Services;

use App\Http\Resources\Equipment\IndexResource;
use App\Http\Resources\Equipment\ShowResource;
use App\Models\Equipment;
use App\Models\EquipmentBrand;
use App\Repositories\EquipmentRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EquipmentService
{
    protected EquipmentRepository $repository;

    public function __construct(EquipmentRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $equipments = $this->repository->getAll();
        return IndexResource::collection($equipments);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $equipment = $this->repository->create($data);
            return new ShowResource($equipment);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(Equipment $equipment): ShowResource
    {
        return new ShowResource($this->repository->getById($equipment));
    }

    /**
     * @throws Exception
     */
    public function update(Equipment $equipment, array $data): ShowResource
    {
        try {
            $this->repository->update($equipment);
            return new ShowResource($equipment);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Equipment $equipment): ?bool
    {
        try {
            return $this->repository->delete($equipment);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
