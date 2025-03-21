<?php

namespace App\Services;

use App\Models\EquipmentBrand;
use App\Repositories\EquipmentBrandRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class EquipmentBrandService
{
    protected EquipmentBrandRepository $repository;

    public function __construct(EquipmentBrandRepository $repository)
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
    public function store(array $data): EquipmentBrand
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): EquipmentBrand
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(EquipmentBrand $equipmentBrand, array $data): EquipmentBrand
    {
        try {
            return $this->repository->update($equipmentBrand, $data);
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
