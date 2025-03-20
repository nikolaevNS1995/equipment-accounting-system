<?php

namespace App\Repositories;

use App\Models\Cabinet;
use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CabinetRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('cabinets:all', function () {
            return Cabinet::with('building', 'cabinetType')->get();
        });
    }

    public function create(array $data): Cabinet
    {
        $cabinet = Cabinet::create($data);
        $cabinet->load('building', 'cabinetType');
        $this->clearCache($cabinet);
        Cache::put('cabinets:' . $cabinet->id, $cabinet);
        return $cabinet;
    }

    public function getById(int $id): Cabinet
    {
        return Cache::rememberForever('cabinets:' . $id, function () use ($id) {
            return Cabinet::with('building', 'cabinetType')->findOrFail($id);
        });
    }

    public function update(Cabinet $cabinet, array $data): Cabinet
    {
        $cabinet->update($data);
        $cabinet->load('building', 'cabinetType');
        $this->clearCache($cabinet);
        Cache::put('cabinets:' . $cabinet->id, $cabinet);
        return $cabinet;
    }

    public function delete(Cabinet $cabinet): ?bool
    {
        Cache::forget('cabinets:' . $cabinet->id);
        $this->clearCache($cabinet);
        return $cabinet->delete();
    }

    public function getCabinetById(Building $building, int $floor): Collection
    {
        return Cache::rememberForever('cabinets:building:'. $building->id . ':floor:' . $floor, function () use ($building, $floor) {
            return Cabinet::where('building_id', $building->id)
                ->where('floor', $floor)
                ->with('building', 'cabinetType')
                ->get();
        });
    }

    protected function clearCache($cabinet): void
    {
        Cache::forget('cabinets:all');
        Cache::forget('cabinets:building:' . $cabinet->building->id . ':floor:' . $cabinet->floor);
    }
}
