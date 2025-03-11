<?php

namespace App\Repositories;

use App\Models\EquipmentModel;
use Illuminate\Database\Eloquent\Collection;

class EquipmentModelRepository
{
    public function getAll(): Collection
    {
        return EquipmentModel::all();
    }

    public function getById(EquipmentModel $equipmentModel): EquipmentModel
    {
        return $equipmentModel;
    }

    public function create($data): EquipmentModel
    {
        return EquipmentModel::create($data);
    }

    public function update(EquipmentModel $equipmentModel, array $data): bool
    {
        return $equipmentModel->update($data);
    }

    public function delete(EquipmentModel $equipmentModel): bool
    {
        return $equipmentModel->delete();
    }
}
