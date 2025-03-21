<?php

namespace App\Services;

use App\Models\CabinetType;
use App\Repositories\CabinetTypeRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class CabinetTypeService
{
    protected CabinetTypeRepository $repository;

    public function __construct(CabinetTypeRepository $repository)
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
    public function store(array $data): CabinetType
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): CabinetType
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(CabinetType $cabinetType, array $data): CabinetType
    {
        try {
            return $this->repository->update($cabinetType, $data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(CabinetType $cabinetType): bool
    {
        try {
            return $this->repository->delete($cabinetType);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
