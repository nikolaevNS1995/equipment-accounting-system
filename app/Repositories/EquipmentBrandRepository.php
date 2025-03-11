<?php

namespace App\Repositories;

use App\Http\Requests\EquipmentBrand\StoreEquipmentBrandRequest;
use App\Models\EquipmentBrand;
use Illuminate\Database\Eloquent\Collection;

class EquipmentBrandRepository
{
    public function getAll(): Collection
    {
        return EquipmentBrand::all();
    }

    public function create(array $data): EquipmentBrand
    {
        return EquipmentBrand::create($data);
    }

    public function getById(EquipmentBrand $equipmentBrand)
    {
        return $equipmentBrand;
    }

    public function update(EquipmentBrand $equipmentBrand, array $data): bool
    {
        return $equipmentBrand->update($data);
    }

    public function delete(EquipmentBrand $equipmentBrand): bool
    {
        return $equipmentBrand->delete();
    }
}
