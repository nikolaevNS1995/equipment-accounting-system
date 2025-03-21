<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentBrand\StoreEquipmentBrandRequest;
use App\Http\Requests\EquipmentBrand\UpdateEquipmentBrandRequest;
use App\Http\Resources\EquipmentBrand\IndexResource;
use App\Http\Resources\EquipmentBrand\ShowResource;
use App\Models\EquipmentBrand;
use App\Services\EquipmentBrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="EquipmentBrands",
 *     description="Управление брендами оборудования"
 * )
 */
class EquipmentBrandController extends Controller
{
    protected EquipmentBrandService $service;

    public function __construct(EquipmentBrandService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *       path="/api/equipment-brands",
     *       summary="Получить список всех брендов оборудования",
     *       tags={"EquipmentBrands"},
     *       security={{ "bearerAuth": {} }},
     *       @OA\Response(
     *           response=200,
     *           description="Список брендов оборудования",
     *           @OA\JsonContent(
     *               allOf={
     *                   @OA\Schema(ref="#/components/schemas/EquipmentBrandIndexResource")
     *               }
     *           )
     *       )
     *   )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentBrand::class);
        $equipmentBrands = $this->service->index();
        return IndexResource::collection($equipmentBrands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *       path="/api/equipment-brands",
     *       summary="Создать новый бренд оборудования",
     *       tags={"EquipmentBrands"},
     *       security={{ "bearerAuth": {} }},
     *       @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/StoreEquipmentBrandRequest")
     *       ),
     *       @OA\Response(
     *           response=201,
     *           description="Бренд оборудования создан",
     *           @OA\JsonContent(ref="#/components/schemas/EquipmentBrandShowResource")
     *       )
     *   )
     * @throws \Exception
     */
    public function store(StoreEquipmentBrandRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentBrand::class);
        $data = $request->validated();
        $equipmentBrand = $this->service->store($data);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *        path="/api/equipment-brands/{id}",
     *        summary="Получить бренд оборудования",
     *        tags={"EquipmentBrands"},
     *        security={{ "bearerAuth": {} }},
     *        @OA\Parameter(
     *            name="id",
     *            in="path",
     *            required=true,
     *            example=1,
     *            description="ID бренда оборудования"
     *        ),
     *        @OA\Response(
     *            response=200,
     *            description="Бренд оборудования",
     *            @OA\JsonContent(
     *                allOf={
     *                    @OA\Schema(ref="#/components/schemas/EquipmentBrandShowResource")
     *                }
     *            )
     *        )
     *    )
     */
    public function show(int $id): ShowResource
    {
        $equipmentBrand = $this->service->show($id);
        Gate::authorize('view', $equipmentBrand);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *        path="/api/equipment-brands/{equipment_brand}",
     *        summary="Обновить бренд оборудования",
     *        tags={"EquipmentBrands"},
     *        security={{ "bearerAuth": {} }},
     *        @OA\Parameter(
     *             name="equipment_brand",
     *             in="path",
     *             required=true,
     *             example=1,
     *             description="ID бренда оборудования"
     *        ),
     *        @OA\RequestBody(
     *            required=true,
     *            @OA\JsonContent(ref="#/components/schemas/UpdateEquipmentBrandRequest")
     *        ),
     *        @OA\Response(
     *            response=200,
     *            description="Бренд оборудования изменен",
     *            @OA\JsonContent(ref="#/components/schemas/EquipmentBrandShowResource")
     *        )
     *    )
     * @throws \Exception
     */
    public function update(UpdateEquipmentBrandRequest $request, EquipmentBrand $equipmentBrand): ShowResource
    {
        Gate::authorize('update', $equipmentBrand);
        $data = $request->validated();
        $equipmentBrand = $this->service->update($equipmentBrand, $data);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *         path="/api/equipment-brands/{equipment_brand}",
     *         summary="Удалить бренд оборудования",
     *         tags={"EquipmentBrands"},
     *         security={{ "bearerAuth": {} }},
     *         @OA\Parameter(
     *              name="equipment_brand",
     *              in="path",
     *              required=true,
     *              example=1,
     *              description="ID бренда оборудования"
     *         ),
     *         @OA\Response(
     *             response=204,
     *             description="Бренд оборудования удален",
     *         )
     *     )
     * @throws \Exception
     */
    public function destroy(EquipmentBrand $equipmentBrand): Response|JsonResponse
    {
        Gate::authorize('delete', $equipmentBrand);
        if ($this->service->destroy($equipmentBrand)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление бренда оборудования']);
        }
    }
}
