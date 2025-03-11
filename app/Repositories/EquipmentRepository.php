<?php

namespace App\Repositories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Collection;

class EquipmentRepository
{
    public function getAll(): Collection
    {
        return Equipment::all();
    }

    public function getById(Equipment $equipment): Equipment
    {
        return $equipment;
    }

    public function create(array $data): Equipment
    {
        return Equipment::create($data);
    }

    public function update(Equipment $equipment): bool
    {
        return $equipment->update();
    }

    public function delete(Equipment $equipment): bool
    {
        return $equipment->delete();
    }
}
