<?php

namespace App\Repositories;

use App\Models\Furniture;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FurnitureRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('furniture:all', function () {
            return Furniture::with('furnitureType', 'cabinet')->get();
        });
    }

    public function create(array $data): Furniture
    {
        $furniture = Furniture::create($data);
        $furniture->load('furnitureType', 'cabinet');
        Cache::forget('furniture:all');
        Cache::put('furniture:' . $furniture->id, $furniture);
        return $furniture;
    }

    public function getById(int $id): Furniture
    {
        return Cache::rememberForever('furniture:' . $id, function () use($id) {
            return Furniture::with('furnitureType', 'cabinet')->findOrFail($id);
        });
    }

    public function update(Furniture $furniture, array $data): Furniture
    {
        $furniture->update($data);
        $furniture->load('furnitureType', 'cabinet');
        Cache::forget('furniture:all');
        Cache::put('furniture:' . $furniture->id, $furniture);
        return $furniture;
    }

    public function delete(Furniture $furniture): bool
    {
        Cache::forget('furniture:all');
        Cache::forget('furniture:' . $furniture->id);
        return $furniture->delete();
    }
}
