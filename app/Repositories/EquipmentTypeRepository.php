<?php

namespace App\Repositories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Collection;

class EquipmentTypeRepository
{
    public function getAll(): Collection
    {
        return EquipmentType::all();
    }

    public function create(array $data): EquipmentType
    {
        return EquipmentType::create($data);
    }

    public function getById(EquipmentType $equipmentType): EquipmentType
    {
        return $equipmentType;
    }

    public function update(EquipmentType $equipmentType, array $data): bool
    {
        return $equipmentType->update($data);
    }

    public function delete(EquipmentType $equipmentType): bool
    {
        return $equipmentType->delete();
    }
}
