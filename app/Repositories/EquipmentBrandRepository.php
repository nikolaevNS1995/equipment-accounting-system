<?php

namespace App\Repositories;

use App\Models\EquipmentBrand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class EquipmentBrandRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('equipmentBrands:all', function () {
            return EquipmentBrand::with('equipmentType')->get();
        });
    }

    public function create(array $data): EquipmentBrand
    {
        $equipmentBrand = EquipmentBrand::create($data);
        $equipmentBrand->load('equipmentType');
        Cache::forget('equipmentBrands:all');
        Cache::put('equipmentBrands:' . $equipmentBrand->id, $equipmentBrand);
        return $equipmentBrand;
    }

    public function getById(int $id): EquipmentBrand
    {
        return Cache::rememberForever('equipmentBrands:' . $id, function () use ($id) {
            return EquipmentBrand::with('equipmentType')->findOrFail($id);
        });
    }

    public function update(EquipmentBrand $equipmentBrand, array $data): EquipmentBrand
    {
        $equipmentBrand->update($data);
        $equipmentBrand->load('equipmentType');
        Cache::forget('equipmentBrands:all');
        Cache::put('equipmentBrands:' . $equipmentBrand->id, $equipmentBrand);
        return $equipmentBrand;
    }

    public function delete(EquipmentBrand $equipmentBrand): bool
    {
        Cache::forget('equipmentBrands:all');
        Cache::forget('equipmentBrands:' . $equipmentBrand->id);
        return $equipmentBrand->delete();
    }
}
