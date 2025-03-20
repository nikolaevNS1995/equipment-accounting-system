<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Http\Resources\Equipment\IndexResource;
use App\Http\Resources\Equipment\ShowResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="Equipments",
 *     description="Управление оборудованием"
 * )
 */
class EquipmentController extends Controller
{
    protected EquipmentService $service;

    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *          path="/api/equipments",
     *          summary="Получить список всего оборудования",
     *          tags={"Equipments"},
     *          security={{ "bearerAuth": {} }},
     *          @OA\Response(
     *              response=200,
     *              description="Список оборудования",
     *              @OA\JsonContent(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/EquipmentIndexResource")
     *                  }
     *              )
     *          )
     *  )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Equipment::class);
        $equipments = $this->service->index();
        return IndexResource::collection($equipments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *          path="/api/equipments",
     *          summary="Создать новое оборудование",
     *          tags={"Equipments"},
     *          security={{ "bearerAuth": {} }},
     *          @OA\RequestBody(
     *              required=true,
     *              @OA\JsonContent(ref="#/components/schemas/StoreEquipmentRequest")
     *          ),
     *          @OA\Response(
     *              response=201,
     *              description="Оборудование создано",
     *              @OA\JsonContent(ref="#/components/schemas/EquipmentShowResource")
     *          )
     *   )
     * @throws \Exception
     */
    public function store(StoreEquipmentRequest $request): ShowResource
    {
        Gate::authorize('create', Equipment::class);
        $data = $request->validated();
        $equipment = $this->service->store($data);
        return new ShowResource($equipment);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *           path="/api/equipments/{id}",
     *           summary="Получить оборудование",
     *           tags={"Equipments"},
     *           security={{ "bearerAuth": {} }},
     *           @OA\Parameter(
     *               name="id",
     *               in="path",
     *               required=true,
     *               example=1,
     *               description="ID оборудования"
     *           ),
     *           @OA\Response(
     *               response=200,
     *               description="Оборудование",
     *               @OA\JsonContent(
     *                   allOf={
     *                       @OA\Schema(ref="#/components/schemas/EquipmentShowResource")
     *                   }
     *               )
     *           )
     *   )
     */
    public function show(int $id): ShowResource
    {
        $equipment = $this->service->show($id);
        Gate::authorize('view', $equipment);
        return new ShowResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *           path="/api/equipments/{equipment}",
     *           summary="Обновить оборудование",
     *           tags={"Equipments"},
     *           security={{ "bearerAuth": {} }},
     *           @OA\Parameter(
     *                name="equipment",
     *                in="path",
     *                required=true,
     *                example=1,
     *                description="ID оборудования"
     *           ),
     *           @OA\RequestBody(
     *               required=true,
     *               @OA\JsonContent(ref="#/components/schemas/UpdateEquipmentRequest")
     *           ),
     *           @OA\Response(
     *               response=200,
     *               description="Оборудование изменен",
     *               @OA\JsonContent(ref="#/components/schemas/EquipmentShowResource")
     *           )
     *    )
     * @throws \Exception
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): ShowResource
    {
        Gate::authorize('update', $equipment);
        $data = $request->validated();
        $equipment = $this->service->update($equipment, $data);
        return new ShowResource($equipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *            path="/api/equipments/{equipment}",
     *            summary="Удалить оборудование",
     *            tags={"Equipments"},
     *            security={{ "bearerAuth": {} }},
     *            @OA\Parameter(
     *                 name="equipment",
     *                 in="path",
     *                 required=true,
     *                 example=1,
     *                 description="ID оборудования"
     *            ),
     *            @OA\Response(
     *                response=204,
     *                description="Оборудование удалено",
     *            )
     *    )
     * @throws \Exception
     */
    public function destroy(Equipment $equipment): Response|JsonResponse
    {
        Gate::authorize('delete', $equipment);
        if ($this->service->destroy($equipment)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление оборудования']);
        }
    }
}
