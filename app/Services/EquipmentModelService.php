<?php

namespace App\Services;

use App\Models\EquipmentModel;
use App\Repositories\EquipmentModelRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class EquipmentModelService
{
    protected EquipmentModelRepository $repository;

    public function __construct(EquipmentModelRepository $repository)
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
    public function store(array $data): EquipmentModel
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function show(int $id): EquipmentModel
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(EquipmentModel $equipmentModel, array $data): EquipmentModel
    {
        try {
            return $this->repository->update($equipmentModel, $data);
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
