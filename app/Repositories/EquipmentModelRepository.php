<?php

namespace App\Repositories;

use App\Models\EquipmentModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class EquipmentModelRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('equipmentModels:all', function () {
            return EquipmentModel::with('equipmentBrand.equipmentType')->get();
        });
    }

    public function getById(int $id): EquipmentModel
    {
        return Cache::rememberForever('equipmentModels:' . $id, function () use ($id) {
            return EquipmentModel::with('equipmentBrand.equipmentType')->findOrFail($id);
        });
    }

    public function create($data): EquipmentModel
    {
        $equipmentModel = EquipmentModel::create($data);
        $equipmentModel->load('equipmentBrand.equipmentType');
        Cache::forget('equipmentModels:all');
        Cache::put('equipmentModels:' . $equipmentModel->id, $equipmentModel);
        return $equipmentModel;
    }

    public function update(EquipmentModel $equipmentModel, array $data): EquipmentModel
    {
        $equipmentModel->update($data);
        $equipmentModel->load('equipmentBrand.equipmentType');
        Cache::forget('equipmentModels:all');
        Cache::put('equipmentModels:'. $equipmentModel->id, $equipmentModel);
        return $equipmentModel;
    }

    public function delete(EquipmentModel $equipmentModel): bool
    {
        Cache::forget('equipmentModels:all');
        Cache::forget('equipmentModels:' . $equipmentModel->id);
        return $equipmentModel->delete();
    }
}
