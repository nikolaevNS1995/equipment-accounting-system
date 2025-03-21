<?php

namespace App\Repositories;

use App\Models\FurnitureType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FurnitureTypeRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('furnitureTypes:all', function () {
            return FurnitureType::all();
        });
    }

    public function create(array $data): FurnitureType
    {
        $furnitureType = FurnitureType::create($data);
        Cache::forget('furnitureTypes:all');
        Cache::put('furnitureTypes:' . $furnitureType->id, $furnitureType);
        return $furnitureType;
    }

    public function getById(int $id): FurnitureType
    {
        return Cache::rememberForever('furnitureTypes:' . $id, function () use ($id){
            return FurnitureType::findOrFail($id);
        });
    }

    public function update(FurnitureType $furnitureType, array $data): FurnitureType
    {
        $furnitureType->update($data);
        Cache::forget('furnitureTypes:all');
        Cache::put('furnitureTypes:' . $furnitureType->id, $furnitureType);
        return $furnitureType;
    }

    public function delete(FurnitureType $furnitureType): bool
    {
        Cache::forget('furnitureTypes:all');
        Cache::forget('furnitureTypes:' . $furnitureType->id);
        return $furnitureType->delete();
    }
}
