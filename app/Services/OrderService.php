<?php

namespace App\Services;

use App\Http\Resources\Order\IndexResource;
use App\Http\Resources\Order\ShowResource;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * @throws Exception
     */
    public function store(array $data): Order
    {
        try {
            $items = $data['items'];
            unset($data['items']);
            DB::beginTransaction();
            $order = Order::create($data);
            foreach ($items as $item) {
                if ($item['orderable_type'] === 'App\Models\Equipment') {
                    $order->equipments()->attach($item);
                }
                if ($item['orderable_type'] === 'App\Models\Furniture') {
                    $order->furnitures()->attach($item);
                }
            }
            $order = $this->repository->create($order);
            DB::commit();
            return $order;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function show(int $id): Order
    {
        return $this->repository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function update(Order $order, array $data): Order
    {
        try {
            $items = $data['items'];
            unset($data['items']);
            DB::beginTransaction();
            $order->update($data);
            foreach ($items as $item) {
                if ($item['orderable_type'] === 'App\Models\Equipment') {
                    $order->equipments()->sync($item);
                }
                if ($item['orderable_type'] === 'App\Models\Furniture') {
                    $order->furnitures()->sync($item);
                }
            }
            $order = $this->repository->update($order);
            DB::commit();
            return $order;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Order $order): bool
    {
        try {
            DB::beginTransaction();
            $this->repository->delete($order);
            DB::commit();
            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
