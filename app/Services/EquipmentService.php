<?php

namespace App\Services;

use App\Models\Equipment;
use App\Repositories\EquipmentRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class EquipmentService
{
    protected EquipmentRepository $repository;

    public function __construct(EquipmentRepository $repository)
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
    public function store(array $data): Equipment
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): Equipment
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(Equipment $equipment, array $data): Equipment
    {
        try {
            return $this->repository->update($equipment);
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
