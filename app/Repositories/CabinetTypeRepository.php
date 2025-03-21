<?php

namespace App\Repositories;

use App\Models\CabinetType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CabinetTypeRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('cabinetTypes:all', function () {
            return CabinetType::all();
        });
    }

    public function getById(int $id): CabinetType
    {
        return Cache::rememberForever('cabinetTypes:' . $id, function () use ($id) {
            return CabinetType::findOrFail($id);
        });
    }

    public function create(array $data): CabinetType
    {
        $cabinetType = CabinetType::create($data);
        Cache::forget('cabinetTypes:all');
        Cache::put('cabinetTypes:' . $cabinetType->id, $cabinetType);
        return $cabinetType;
    }

    public function update(CabinetType $cabinetType, array $data): CabinetType
    {
        $cabinetType->update($data);
        Cache::forget('cabinetTypes:all');
        Cache::put('cabinetTypes:' . $cabinetType->id, $cabinetType);
        return $cabinetType;
    }

    public function delete(CabinetType $cabinetType): ?bool
    {
        Cache::forget('cabinetTypes:all');
        Cache::forget('cabinetTypes:' . $cabinetType->id);
        return $cabinetType->delete();
    }
}
