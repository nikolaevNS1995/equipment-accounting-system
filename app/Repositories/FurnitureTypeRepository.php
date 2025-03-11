<?php

namespace App\Repositories;

use App\Models\FurnitureType;
use Illuminate\Database\Eloquent\Collection;

class FurnitureTypeRepository
{
    public function getAll(): Collection
    {
        return FurnitureType::all();
    }

    public function create(array $data): FurnitureType
    {
        return FurnitureType::create($data);
    }

    public function getById(FurnitureType $furnitureType): FurnitureType
    {
        return $furnitureType;
    }

    public function update(FurnitureType $furnitureType, array $data): bool
    {
        return $furnitureType->update($data);
    }

    public function delete(FurnitureType $furnitureType): bool
    {
        return $furnitureType->delete();
    }
}
