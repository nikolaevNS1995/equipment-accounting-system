<?php

namespace App\Repositories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BuildingRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('buildings:all', function () {
            return Building::get();
        });
    }

    public function create(array $data): Building
    {
        $building = Building::create($data);
        Cache::forget('buildings:all');
        Cache::put('buildings:' . $building->id, $building);
        return $building;
    }

    public function getById(int $id): Building
    {
        return Cache::rememberForever('buildings:' . $id, function () use ($id) {
            return Building::findOrFail($id);
        });
    }

    public function update(Building $building, array $data): Building
    {
        $building->update($data);
        Cache::forget('buildings:all');
        Cache::put('buildings:' . $building->id, $building);
        return $building;
    }

    public function delete(Building $building): ?bool
    {
        Cache::forget('buildings:' . $building->id);
        Cache::forget('buildings:all');
        return $building->delete();
    }
}
