<?php

namespace App\Services;

use App\Http\Resources\Order\IndexResource;
use App\Http\Resources\Order\ShowResource;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Exception;
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

    public function index(): AnonymousResourceCollection
    {
        $orders = $this->repository->getAll();
        return IndexResource::collection($orders);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): ShowResource
    {
        try {
            $items = $data['items'];
            unset($data['items']);
            DB::beginTransaction();
            $order = $this->repository->create($data);
            foreach ($items as $item) {
                if ($item['orderable_type'] === 'App\Models\Equipment') {
                    $this->repository->createItemEquipment($order, $item);
                }
                if ($item['orderable_type'] === 'App\Models\Furniture') {
                    $this->repository->createItemFurniture($order, $item);
                }
            }
            DB::commit();
            return new ShowResource($order);
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function show(Order $order): ShowResource
    {
        return new ShowResource($this->repository->getById($order));
    }

    /**
     * @throws Exception
     */
    public function update(Order $order, array $data): ShowResource
    {
        try {
            $items = $data['items'];
            unset($data['items']);
            DB::beginTransaction();
            $this->repository->update($order, $data);
            foreach ($items as $item) {
                if ($item['orderable_type'] === 'App\Models\Equipment') {
                    $this->repository->updateItemEquipment($order, $item);
                }
                if ($item['orderable_type'] === 'App\Models\Furniture') {
                    $this->repository->updateItemFurniture($order, $item);
                }
            }
            DB::commit();
            return new ShowResource($order);
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
            $this->repository->deleteItemEquipment($order);
            $this->repository->deleteItemFurniture($order);
            $this->repository->delete($order);
            DB::commit();
            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
