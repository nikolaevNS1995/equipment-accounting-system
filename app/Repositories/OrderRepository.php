<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class OrderRepository
{
    public function getAll(): Collection
    {
        return Cache::rememberForever('orders:all', function () {
            return Order::with('user')->get();
        });
    }

    public function create(Order $order): Order
    {
        $order->load('user', 'equipments.equipmentModel', 'equipments.cabinet', 'furnitures.furnitureType', 'furnitures.cabinet');
        Cache::forget('orders:all');
        Cache::put('orders:' . $order->id, $order);
        return $order;
    }

    public function getById(int $id): Order
    {
        return Cache::rememberForever('orders:' . $id, function () use ($id) {
            return Order::with('user', 'equipments.equipmentModel', 'equipments.cabinet', 'furnitures.furnitureType', 'furnitures.cabinet')->findOrFail($id);
        });
    }

    public function update(Order $order): Order
    {
        $order->load('user', 'equipments.equipmentModel', 'equipments.cabinet', 'furnitures.furnitureType', 'furnitures.cabinet');
        Cache::forget('orders:all');
        Cache::put('orders:' . $order->id, $order);
        return $order;
    }

    public function delete(Order $order): ?bool
    {
        $order->equipments()->detach();
        $order->furnitures()->detach();
        Cache::forget('orders:all');
        Cache::forget('orders' . $order->id);
        return $order->delete();
    }
}
