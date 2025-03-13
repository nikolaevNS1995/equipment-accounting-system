<?php

namespace App\Repositories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class EquipmentRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('equipments:all', function () {
            return Equipment::with('equipmentModel', 'cabinet', 'equipmentModel.equipmentBrand.equipmentType')->get();
        });
    }

    public function getById(int $id): Equipment
    {
        return Cache::rememberForever('equipments:' . $id, function () use ($id) {
            return Equipment::with('equipmentModel', 'cabinet', 'equipmentModel.equipmentBrand.equipmentType')->findOrFail($id);
        });
    }

    public function create(array $data): Equipment
    {
        $equipment = Equipment::create($data);
        $equipment->load('equipmentModel', 'cabinet', 'equipmentModel.equipmentBrand.equipmentType');
        Cache::forget('equipments:all');
        Cache::put('equipments:' . $equipment->id, $equipment);
        return $equipment;
    }

    public function update(Equipment $equipment): Equipment
    {
        $equipment->update();
        $equipment->load('equipmentModel', 'cabinet', 'equipmentModel.equipmentBrand.equipmentType');
        Cache::forget('equipments:all');
        Cache::put('equipments:' . $equipment->id, $equipment);
        return $equipment;
    }

    public function delete(Equipment $equipment): bool
    {
        Cache::forget('equipments:all');
        Cache::forget('equipments:' . $equipment->id);
        return $equipment->delete();
    }
}
