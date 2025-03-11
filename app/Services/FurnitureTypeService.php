<?php

namespace App\Services;

use App\Http\Resources\FurnitureType\IndexResource;
use App\Http\Resources\FurnitureType\ShowResource;
use App\Models\FurnitureType;
use App\Repositories\FurnitureTypeRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FurnitureTypeService
{
    protected FurnitureTypeRepository $repository;

    public function __construct(FurnitureTypeRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $furnitureType = $this->repository->getAll();
        return IndexResource::collection($furnitureType);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $furnitureType = $this->repository->create($data);
            return new ShowResource($furnitureType);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(FurnitureType $furnitureType): ShowResource
    {
        return new ShowResource($this->repository->getById($furnitureType));
    }

    /**
     * @throws Exception
     */
    public function update(FurnitureType $furnitureType, array $data): ShowResource
    {
        try {
            $this->repository->update($furnitureType, $data);
            return new ShowResource($furnitureType);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(FurnitureType $furnitureType): bool
    {
        try {
            return $this->repository->delete($furnitureType);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
