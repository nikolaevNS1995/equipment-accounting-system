<?php

namespace App\Services;

use App\Http\Resources\Cabinet\IndexResource;
use App\Http\Resources\Cabinet\ShowResource;
use App\Models\Cabinet;
use App\Models\Building;
use App\Repositories\CabinetRepository;
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
    public function index(): AnonymousResourceCollection
    {
        $cabinets = $this->repository->getAll();
        return IndexResource::collection($cabinets);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $cabinet = $this->repository->create($data);
            return new ShowResource($cabinet);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(Cabinet $cabinet): ShowResource
    {
        return new ShowResource($this->repository->getById($cabinet));
    }

    /**
     * @throws Exception
     */
    public function update(Cabinet $cabinet, array $data): ShowResource
    {
        try {
            $this->repository->update($cabinet, $data);
            return new ShowResource($cabinet);
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

    public function getCabinetsByFloor(Building $building, int $floor): AnonymousResourceCollection
    {
        $cabinets = $this->repository->getCabinetById($building, $floor);
        return IndexResource::collection($cabinets);
    }
}
