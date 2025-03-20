<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentModel\StoreEquipmentModelRequest;
use App\Http\Requests\EquipmentModel\UpdateEquipmentModelRequest;
use App\Http\Resources\EquipmentModel\IndexResource;
use App\Http\Resources\EquipmentModel\ShowResource;
use App\Models\EquipmentModel;
use App\Services\EquipmentModelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="EquipmentModels",
 *     description="Управление моделями оборудования"
 * )
 */
class EquipmentModelController extends Controller
{
    protected EquipmentModelService $service;

    public function __construct(EquipmentModelService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *        path="/api/equipment-models",
     *        summary="Получить список всех моделей оборудования",
     *        tags={"EquipmentModels"},
     *        security={{ "bearerAuth": {} }},
     *        @OA\Response(
     *            response=200,
     *            description="Список моделей оборудования",
     *            @OA\JsonContent(
     *                allOf={
     *                    @OA\Schema(ref="#/components/schemas/EquipmentModelIndexResource")
     *                }
     *            )
     *        )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentModel::class);
        $equipmentModels = $this->service->index();
        return IndexResource::collection($equipmentModels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *        path="/api/equipment-models",
     *        summary="Создать новую модель оборудования",
     *        tags={"EquipmentModels"},
     *        security={{ "bearerAuth": {} }},
     *        @OA\RequestBody(
     *            required=true,
     *            @OA\JsonContent(ref="#/components/schemas/StoreEquipmentModelRequest")
     *        ),
     *        @OA\Response(
     *            response=201,
     *            description="Модель оборудования создана",
     *            @OA\JsonContent(ref="#/components/schemas/EquipmentModelShowResource")
     *        )
     * )
     *
     * @throws \Exception
     */
    public function store(StoreEquipmentModelRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentModel::class);
        $data = $request->validated();
        $equipmentModel = $this->service->store($data);
        return new ShowResource($equipmentModel);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *         path="/api/equipment-models/{id}",
     *         summary="Получить модель оборудования",
     *         tags={"EquipmentModels"},
     *         security={{ "bearerAuth": {} }},
     *         @OA\Parameter(
     *             name="id",
     *             in="path",
     *             required=true,
     *             example=1,
     *             description="ID модели оборудования"
     *         ),
     *         @OA\Response(
     *             response=200,
     *             description="Модель оборудования",
     *             @OA\JsonContent(
     *                 allOf={
     *                     @OA\Schema(ref="#/components/schemas/EquipmentModelShowResource")
     *                 }
     *             )
     *         )
     * )
     */
    public function show(int $id): ShowResource
    {
        $equipmentModel = $this->service->show($id);
        Gate::authorize('view', $equipmentModel);
        return new ShowResource($equipmentModel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *         path="/api/equipment-models/{equipment_model}",
     *         summary="Обновить модель оборудования",
     *         tags={"EquipmentModels"},
     *         security={{ "bearerAuth": {} }},
     *         @OA\Parameter(
     *              name="equipment_model",
     *              in="path",
     *              required=true,
     *              example=1,
     *              description="ID модели оборудования"
     *         ),
     *         @OA\RequestBody(
     *             required=true,
     *             @OA\JsonContent(ref="#/components/schemas/UpdateEquipmentModelRequest")
     *         ),
     *         @OA\Response(
     *             response=200,
     *             description="Модель оборудования изменена",
     *             @OA\JsonContent(ref="#/components/schemas/EquipmentModelShowResource")
     *         )
     *  )
     * @throws \Exception
     */
    public function update(UpdateEquipmentModelRequest $request, EquipmentModel $equipmentModel): ShowResource
    {
        Gate::authorize('update', $equipmentModel);
        $data = $request->validated();
        $equipmentModel = $this->service->update($equipmentModel, $data);
        return new ShowResource($equipmentModel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *          path="/api/equipment-models/{equipment_model}",
     *          summary="Удалить модель оборудования",
     *          tags={"EquipmentModels"},
     *          security={{ "bearerAuth": {} }},
     *          @OA\Parameter(
     *               name="equipment_model",
     *               in="path",
     *               required=true,
     *               example=1,
     *               description="ID модели оборудования"
     *          ),
     *          @OA\Response(
     *              response=204,
     *              description="Модель оборудования удалена",
     *          )
     *  )
     */
    public function destroy(EquipmentModel $equipmentModel): Response|JsonResponse
    {
        Gate::authorize('delete', $equipmentModel);
        if ($this->service->destroy($equipmentModel)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление модели оборудования'], 500);
        }
    }
}
