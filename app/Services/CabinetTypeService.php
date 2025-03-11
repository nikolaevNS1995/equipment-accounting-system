<?php

namespace App\Services;

use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Resources\CabinetType\IndexResource;
use App\Http\Resources\CabinetType\ShowResource;
use App\Models\CabinetType;
use App\Repositories\CabinetTypeRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CabinetTypeService
{
    protected CabinetTypeRepository $repository;

    public function __construct(CabinetTypeRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $cabinetTypes = $this->repository->getAll();
        return IndexResource::collection($cabinetTypes);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $cabinetType = $this->repository->create($data);
            return new ShowResource($cabinetType);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(CabinetType $cabinetType): ShowResource
    {
        return new ShowResource($this->repository->getById($cabinetType));
    }

    /**
     * @throws Exception
     */
    public function update(CabinetType $cabinetType, array $data): ShowResource
    {
        try {
            $this->repository->update($cabinetType, $data);
            return new ShowResource($cabinetType);
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
