<?php

namespace App\Services;

use App\Http\Resources\EquipmentBrand\IndexResource;
use App\Http\Resources\EquipmentBrand\ShowResource;
use App\Models\EquipmentBrand;
use App\Repositories\EquipmentBrandRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EquipmentBrandService
{
    protected EquipmentBrandRepository $repository;

    public function __construct(EquipmentBrandRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $equipmentBrands = $this->repository->getAll();
        return IndexResource::collection($equipmentBrands);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $equipmentBrand = $this->repository->create($data);
            return new ShowResource($equipmentBrand);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(EquipmentBrand $equipmentBrand): ShowResource
    {
        return new ShowResource($this->repository->getById($equipmentBrand));
    }

    /**
     * @throws Exception
     */
    public function update(EquipmentBrand $equipmentBrand, array $data): ShowResource
    {
        try {
            $this->repository->update($equipmentBrand, $data);
            return new ShowResource($equipmentBrand);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(EquipmentBrand $equipmentBrand): bool
    {
        try {
            return $this->repository->delete($equipmentBrand);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
