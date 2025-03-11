<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function getAll(): Collection
    {
        return Order::all();
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function getById(Order $order): Order
    {
        return $order;
    }

    public function update(Order $order, array $data): bool
    {
        return $order->update($data);
    }

    public function delete(Order $order): ?bool
    {
        return $order->delete();
    }

    public function createItemEquipment(Order $order, array $item): void
    {
        $order->equipments()->attach($item);
    }

    public function createItemFurniture(Order $order, array $item): void
    {
        $order->furnitures()->attach($item);
    }

    public function updateItemEquipment(Order $order, array $item): void
    {
        $order->equipments()->sync($item);
    }

    public function updateItemFurniture(Order $order, array $item): void
    {
        $order->furnitures()->sync($item);
    }

    public function deleteItemEquipment(Order $order): void
    {
        $order->equipments()->detach();
    }

    public function deleteItemFurniture(Order $order): void
    {
        $order->furnitures()->detach();
    }
}
