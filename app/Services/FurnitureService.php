<?php

namespace App\Services;

use App\Http\Resources\Furniture\IndexResource;
use App\Http\Resources\Furniture\ShowResource;
use App\Models\Furniture;
use App\Repositories\FurnitureRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FurnitureService
{
    protected FurnitureRepository $repository;

    public function __construct(FurnitureRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(): AnonymousResourceCollection
    {
        $furniture = $this->repository->getAll();
        return IndexResource::collection($furniture);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $furniture = $this->repository->create($data);
            return new ShowResource($furniture);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(Furniture $furniture): ShowResource
    {
        return new ShowResource($this->repository->getById($furniture));
    }

    /**
     * @throws Exception
     */
    public function update(Furniture $furniture, array $data): ShowResource
    {
        try {
            $this->repository->update($furniture, $data);
            return new ShowResource($furniture);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Furniture $furniture): bool
    {
        try {
            return $this->repository->delete($furniture);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
