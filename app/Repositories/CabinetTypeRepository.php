<?php

namespace App\Repositories;

use App\Models\CabinetType;
use Illuminate\Database\Eloquent\Collection;

class CabinetTypeRepository
{
    public function getAll(): Collection
    {
        return CabinetType::all();
    }

    public function getById(CabinetType $cabinetType): CabinetType
    {
        return $cabinetType;
    }

    public function create(array $data): CabinetType
    {
        return CabinetType::create($data);
    }

    public function update(CabinetType $cabinetType, array $data): bool
    {
        return $cabinetType->update($data);
    }

    public function delete(CabinetType $cabinetType): ?bool
    {
        return $cabinetType->delete();
    }
}
