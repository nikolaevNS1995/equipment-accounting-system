<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\IndexResource;
use App\Http\Resources\Order\ShowResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $orders = Order::get();
        return IndexResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): ShowResource
    {
        $data = $request->validated();

        $items = $data['items'];
        unset($data['items']);

        $order = Order::create($data);

        foreach ($items as $item) {
            if ($item['orderable_type'] === 'App\Models\Equipment') {
                $order->equipments()->attach($item);
            }
            if ($item['orderable_type'] === 'App\Models\Furniture') {
                $order->furnitures()->attach($item);
            }
        }

        return new ShowResource($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): ShowResource
    {
        return new ShowResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order): ShowResource
    {
        $data = $request->validated();
        $items = $data['items'];
        unset($data['items']);
        $order->update($data);
        foreach ($items as $item) {
            if ($item['orderable_type'] === 'App\Models\Equipment') {
                $order->equipments()->sync($item);
            }
            if ($item['orderable_type'] === 'App\Models\Furniture') {
                $order->furnitures()->sync($item);
            }
        }
        return new ShowResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): Response
    {
        $order->equipments()->detach();
        $order->furnitures()->detach();
        $order->delete();
        return response()->noContent();
    }
}
