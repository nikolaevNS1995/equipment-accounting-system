<?php

namespace App\Repositories;

use App\Models\Cabinet;
use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

class CabinetRepository
{
    public function getAll(): Collection
    {
        return Cabinet::all();
    }

    public function create(array $data): Cabinet
    {
        return Cabinet::create($data);
    }

    public function getById(Cabinet $cabinet): Cabinet
    {
        return $cabinet;
    }

    public function update(Cabinet $cabinet, array $data): bool
    {
        return $cabinet->update($data);
    }

    public function delete(Cabinet $cabinet): ?bool
    {
        return $cabinet->delete();
    }

    public function getCabinetById(Building $building, int $floor): Collection
    {
        return Cabinet::where('building_id', $building->id)
            ->where('floor', $floor)
            ->get();
    }
}
