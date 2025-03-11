<?php

namespace App\Repositories;

use App\Http\Requests\Furniture\StoreFurnitureRequest;
use App\Models\Furniture;
use Illuminate\Database\Eloquent\Collection;

class FurnitureRepository
{
    public function getAll(): Collection
    {
        return Furniture::all();
    }

    public function create(array $data): Furniture
    {
        return Furniture::create($data);
    }

    public function getById(Furniture $furniture): Furniture
    {
        return $furniture;
    }

    public function update(Furniture $furniture, array $data): bool
    {
        return $furniture->update($data);
    }

    public function delete(Furniture $furniture): bool
    {
        return $furniture->delete();
    }
}
