<?php

namespace App\Services;

use App\Http\Resources\Cabinet\IndexResource;
use App\Http\Resources\Cabinet\ShowResource;
use App\Models\Cabinet;
use App\Models\Building;
use App\Repositories\CabinetRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Exception;

class CabinetService
{
    protected CabinetRepository $repository;

    public function __construct(CabinetRepository $repository)
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
    public function store(array $data): Cabinet
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): Cabinet
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(Cabinet $cabinet, array $data): Cabinet
    {
        try {
            return $this->repository->update($cabinet, $data);
        } catch (QueryException $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Cabinet $cabinet): bool
    {
        try {
            return $this->repository->delete($cabinet);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getCabinetsByFloor(Building $building, int $floor): Collection
    {
        return $this->repository->getCabinetById($building, $floor);
    }
}
