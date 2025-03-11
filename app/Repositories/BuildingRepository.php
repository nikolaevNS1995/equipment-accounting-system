<?php

namespace App\Repositories;

use App\Http\Resources\Building\ShowResource;
use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

class BuildingRepository
{
    public function getAll(): Collection
    {
        return Building::get();
    }

    public function create(array $data): Building
    {
        return Building::create($data);
    }

    public function getById(Building $building): Building
    {
        return $building;
    }

    public function update(Building $building, array $data): bool
    {
        return $building->update($data);
    }

    public function delete(Building $building): bool
    {
        return $building->delete();
    }
}
