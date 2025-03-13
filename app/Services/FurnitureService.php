<?php

namespace App\Services;

use App\Models\Furniture;
use App\Repositories\FurnitureRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class FurnitureService
{
    protected FurnitureRepository $repository;

    public function __construct(FurnitureRepository $repository)
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
    public function store(array $data): Furniture
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): Furniture
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(Furniture $furniture, array $data): Furniture
    {
        try {
            return $this->repository->update($furniture, $data);
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
