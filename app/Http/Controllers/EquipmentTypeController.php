<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentType\StoreEquipmentTypeRequest;
use App\Http\Requests\EquipmentType\UpdateEquipmentTypeRequest;
use App\Http\Resources\EquipmentType\IndexResource;
use App\Http\Resources\EquipmentType\ShowResource;
use App\Models\EquipmentType;
use App\Services\EquipmentTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="EquipmentTypes",
 *     description="Управление типами оборудования"
 * )
 */
class EquipmentTypeController extends Controller
{
    protected EquipmentTypeService $service;

    public function __construct(EquipmentTypeService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *         path="/api/equipment-types",
     *         summary="Получить список всех типов оборудования",
     *         tags={"EquipmentTypes"},
     *         security={{ "bearerAuth": {} }},
     *         @OA\Response(
     *             response=200,
     *             description="Список типов оборудования",
     *             @OA\JsonContent(
     *                 allOf={
     *                     @OA\Schema(ref="#/components/schemas/EquipmentTypeIndexResource")
     *                 }
     *             )
     *         )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentType::class);
        $equipmentTypes = $this->service->index();
        return IndexResource::collection($equipmentTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *         path="/api/equipment-types",
     *         summary="Создать новый тип оборудования",
     *         tags={"EquipmentTypes"},
     *         security={{ "bearerAuth": {} }},
     *         @OA\RequestBody(
     *             required=true,
     *             @OA\JsonContent(ref="#/components/schemas/StoreEquipmentTypeRequest")
     *         ),
     *         @OA\Response(
     *             response=201,
     *             description="Тип оборудования создан",
     *             @OA\JsonContent(ref="#/components/schemas/EquipmentTypeShowResource")
     *         )
     *  )
     * @throws \Exception
     */
    public function store(StoreEquipmentTypeRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentType::class);
        $data = $request->validated();
        $equipmentType = $this->service->store($data);
        return new ShowResource($equipmentType);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *          path="/api/equipment-types/{id}",
     *          summary="Получить тип оборудования",
     *          tags={"EquipmentTypes"},
     *          security={{ "bearerAuth": {} }},
     *          @OA\Parameter(
     *              name="id",
     *              in="path",
     *              required=true,
     *              example=1,
     *              description="ID типа оборудования"
     *          ),
     *          @OA\Response(
     *              response=200,
     *              description="Тип оборудования",
     *              @OA\JsonContent(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/EquipmentTypeShowResource")
     *                  }
     *              )
     *          )
     *  )
     */
    public function show(int $id): ShowResource
    {
        $equipmentType = $this->service->show($id);
        Gate::authorize('view', $equipmentType);
        return new ShowResource($equipmentType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *          path="/api/equipment-types/{equipment_type}",
     *          summary="Обновить тип оборудования",
     *          tags={"EquipmentTypes"},
     *          security={{ "bearerAuth": {} }},
     *          @OA\Parameter(
     *               name="equipment_type",
     *               in="path",
     *               required=true,
     *               example=1,
     *               description="ID типа оборудования"
     *          ),
     *          @OA\RequestBody(
     *              required=true,
     *              @OA\JsonContent(ref="#/components/schemas/UpdateEquipmentTypeRequest")
     *          ),
     *          @OA\Response(
     *              response=200,
     *              description="Тип оборудования изменен",
     *              @OA\JsonContent(ref="#/components/schemas/EquipmentTypeShowResource")
     *          )
     *   )
     * @throws \Exception
     */
    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipmentType): ShowResource
    {
        Gate::authorize('update', $equipmentType);
        $data = $request->validated();
        $equipmentType = $this->service->update($equipmentType, $data);
        return new ShowResource($equipmentType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *           path="/api/equipment-types/{equipment_type}",
     *           summary="Удалить тип оборудования",
     *           tags={"EquipmentTypes"},
     *           security={{ "bearerAuth": {} }},
     *           @OA\Parameter(
     *                name="equipment_type",
     *                in="path",
     *                required=true,
     *                example=1,
     *                description="ID типа оборудования"
     *           ),
     *           @OA\Response(
     *               response=204,
     *               description="Тип оборудования удален",
     *           )
     *   )
     * @throws \Exception
     */
    public function destroy(EquipmentType $equipmentType): Response|JsonResponse
    {
        Gate::authorize('delete', $equipmentType);
        if ($this->service->destroy($equipmentType)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление типа оборудования'], 500);
        }
    }
}
