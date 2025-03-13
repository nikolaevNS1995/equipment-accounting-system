<?php

namespace App\Repositories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class EquipmentTypeRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('equipmentTypes:all', function () {
            return EquipmentType::all();
        });
    }

    public function create(array $data): EquipmentType
    {
        $equipmentType = EquipmentType::create($data);
        Cache::forget('equipmentTypes:all');
        Cache::put('equipmentTypes:' . $equipmentType->id, $equipmentType);
        return $equipmentType;
    }

    public function getById(int $id): EquipmentType
    {
        return Cache::rememberForever('equipmentTypes:' . $id, function () use ($id) {
            return EquipmentType::findOrFail($id);
        });
    }

    public function update(EquipmentType $equipmentType, array $data): EquipmentType
    {
        $equipmentType->update($data);
        Cache::forget('equipmentTypes:all');
        Cache::put('equipmentTypes:' . $equipmentType->id, $equipmentType);
        return $equipmentType;
    }

    public function delete(EquipmentType $equipmentType): bool
    {
        Cache::forget('equipmentTypes:all');
        Cache::forget('equipmentTypes:' . $equipmentType->id);
        return $equipmentType->delete();
    }
}
