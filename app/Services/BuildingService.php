<?php

namespace App\Services;

use App\Http\Resources\Building\IndexResource;
use App\Http\Resources\Building\ShowResource;
use App\Models\Building;
use App\Repositories\BuildingRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Mockery\Exception;

class BuildingService
{
    protected BuildingRepository $repository;

    public function __construct(BuildingRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $buildings = $this->repository->getAll();
        return IndexResource::collection($buildings);
    }

    public function store(array $data): ShowResource
    {
        try {
            $building = $this->repository->create($data);
            return new ShowResource($building);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(Building $building): ShowResource
    {
        return new ShowResource($this->repository->getById($building));
    }

    public function update(Building $building, array $data): ShowResource
    {
        try {
            $this->repository->update($building, $data);
            return new ShowResource($building);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function destroy(Building $building): bool
    {
        try {
            return $this->repository->delete($building);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
