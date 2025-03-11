<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\IndexResource;
use App\Http\Resources\Order\ShowResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Order::class);
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreOrderRequest $request): ShowResource
    {
        Gate::authorize('create', Order::class);
        $data = $request->validated();
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): ShowResource
    {
        Gate::authorize('view', $order);
        return $this->service->show($order);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateOrderRequest $request, Order $order): ShowResource
    {
        Gate::authorize('update', $order);
        $data = $request->validated();
        return $this->service->update($order, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): Response
    {
        Gate::authorize('delete', $order);

        return response()->noContent();
    }
}
