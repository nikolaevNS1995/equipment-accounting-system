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

/**
 * @OA\Tag(
 *     name="Orders",
 *     description="Управление заявками"
 * )
 */
class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *            path="/api/orders",
     *            summary="Получить список всех заявок",
     *            tags={"Orders"},
     *            security={{ "bearerAuth": {} }},
     *            @OA\Response(
     *                response=200,
     *                description="Список заявок",
     *                @OA\JsonContent(
     *                    allOf={
     *                        @OA\Schema(ref="#/components/schemas/OrderIndexResource")
     *                    }
     *                )
     *            )
     *    )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Order::class);
        $orders = $this->service->index();
        return IndexResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *            path="/api/orders",
     *            summary="Создать новую заявку",
     *            tags={"Orders"},
     *            security={{ "bearerAuth": {} }},
     *            @OA\RequestBody(
     *                required=true,
     *                @OA\JsonContent(ref="#/components/schemas/StoreOrderRequest")
     *            ),
     *            @OA\Response(
     *                response=201,
     *                description="Заявка создана",
     *                @OA\JsonContent(ref="#/components/schemas/OrderShowResource")
     *            )
     *     )
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
     *
     * @OA\Get(
     *             path="/api/orders/{id}",
     *             summary="Получить заявку",
     *             tags={"Orders"},
     *             security={{ "bearerAuth": {} }},
     *             @OA\Parameter(
     *                 name="id",
     *                 in="path",
     *                 required=true,
     *                 example=1,
     *                 description="ID заявки"
     *             ),
     *             @OA\Response(
     *                 response=200,
     *                 description="Заявка",
     *                 @OA\JsonContent(
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/OrderShowResource")
     *                     }
     *                 )
     *             )
     *     )
     */
    public function show(int $id): ShowResource
    {
        $order = $this->service->show($id);
        Gate::authorize('view', $order);
        return new ShowResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *             path="/api/orders/{order}",
     *             summary="Обновить заявку",
     *             tags={"Orders"},
     *             security={{ "bearerAuth": {} }},
     *             @OA\Parameter(
     *                  name="order",
     *                  in="path",
     *                  required=true,
     *                  example=1,
     *                  description="ID заявки"
     *             ),
     *             @OA\RequestBody(
     *                 required=true,
     *                 @OA\JsonContent(ref="#/components/schemas/UpdateOrderRequest")
     *             ),
     *             @OA\Response(
     *                 response=200,
     *                 description="Заявка изменена",
     *                 @OA\JsonContent(ref="#/components/schemas/OrderShowResource")
     *             )
     *      )
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
     *
     * @OA\Delete(
     *              path="/api/orders/{order}",
     *              summary="Удалить заявку",
     *              tags={"Orders"},
     *              security={{ "bearerAuth": {} }},
     *              @OA\Parameter(
     *                   name="order",
     *                   in="path",
     *                   required=true,
     *                   example=1,
     *                   description="ID заявки"
     *              ),
     *              @OA\Response(
     *                  response=204,
     *                  description="Заявка удалена",
     *              )
     *      )
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
