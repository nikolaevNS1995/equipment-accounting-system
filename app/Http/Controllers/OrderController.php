<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\IndexResource;
use App\Http\Resources\Order\ShowResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
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
        $orders = $this->service->index();
        return IndexResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreOrderRequest $request): ShowResource
    {
        Gate::authorize('create', Order::class);
        $data = $request->validated();
        $order = $this->service->store($data);
        return new ShowResource($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ShowResource
    {
        $order = $this->service->show($id);
        Gate::authorize('view', $order);
        return new ShowResource($order);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateOrderRequest $request, Order $order): ShowResource
    {
        Gate::authorize('update', $order);
        $data = $request->validated();
        $order = $this->service->update($order, $data);
        return new ShowResource($order);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(Order $order): Response|JsonResponse
    {
        Gate::authorize('delete', $order);
        if ($this->service->destroy($order)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление заказа'], 500);
        }
    }
}
