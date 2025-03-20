<?php

namespace App\Http\Controllers;

use App\Http\Requests\CabinetType\StoreCabinetTypeRequest;
use App\Http\Requests\CabinetType\UpdateCabinetTypeRequest;
use App\Http\Resources\CabinetType\IndexResource;
use App\Http\Resources\CabinetType\ShowResource;
use App\Models\CabinetType;
use App\Services\CabinetTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="CabinetTypes",
 *     description="Управление типами кабинетов"
 * )
 */
class CabinetTypeController extends Controller
{
    protected CabinetTypeService $service;

    public function __construct(CabinetTypeService $service)
    {
        $this->service = $service;
    }
    /**
     *  Display a listing of the resource.
     *  @OA\Get(
     *      path="/api/cabinet-types",
     *      summary="Получить список всех типов кабинета",
     *      tags={"CabinetTypes"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Список типов кабинета",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/CabinetTypeIndexResource")
     *              }
     *          )
     *      )
     *  )
     *
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', CabinetType::class);
        $cabinetTypes = $this->service->index();
        return IndexResource::collection($cabinetTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/cabinet-types",
     *      summary="Создать новый тип кабинета",
     *      tags={"CabinetTypes"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCabinetTypeRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Кабинет создан",
     *          @OA\JsonContent(ref="#/components/schemas/CabinetTypeShowResource")
     *      )
     *  )
     *
     * @throws \Exception
     */
    public function store(StoreCabinetTypeRequest $request): ShowResource
    {
        Gate::authorize('create', CabinetType::class);
        $data = $request->validated();
        $cabinetType = $this->service->store($data);
        return new ShowResource($cabinetType);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *       path="/api/cabinet-types/{id}",
     *       summary="Получить тип кабинета",
     *       tags={"CabinetTypes"},
     *       security={{ "bearerAuth": {} }},
     *       @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           example=1,
     *           description="ID типа кабинета"
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Тип кабинета",
     *           @OA\JsonContent(
     *               allOf={
     *                   @OA\Schema(ref="#/components/schemas/CabinetTypeShowResource")
     *               }
     *           )
     *       )
     *   )
     */
    public function show(int $id): ShowResource
    {
        $cabinetType = $this->service->show($id);
        Gate::authorize('view', $cabinetType);
        return new ShowResource($cabinetType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *       path="/api/cabinet-types/{cabinet_type}",
     *       summary="Обновить тип кабинета",
     *       tags={"CabinetTypes"},
     *       security={{ "bearerAuth": {} }},
     *       @OA\Parameter(
     *            name="cabinet_type",
     *            in="path",
     *            required=true,
     *            example=1,
     *            description="ID типа кабинета"
     *       ),
     *       @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/UpdateCabinetTypeRequest")
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Тип кабинета изменен",
     *           @OA\JsonContent(ref="#/components/schemas/CabinetTypeShowResource")
     *       )
     *   )
     *
     * @throws \Exception
     */
    public function update(UpdateCabinetTypeRequest $request, CabinetType $cabinetType): ShowResource
    {
        Gate::authorize('update', $cabinetType);
        $data = $request->validated();
        $cabinetTypeUpdated = $this->service->update($cabinetType, $data);
        return new ShowResource($cabinetTypeUpdated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *        path="/api/cabinet-types/{cabinet_type}",
     *        summary="Удалить тип кабинет",
     *        tags={"CabinetTypes"},
     *        security={{ "bearerAuth": {} }},
     *        @OA\Parameter(
     *             name="cabinet_type",
     *             in="path",
     *             required=true,
     *             example=1,
     *             description="ID типа кабинета"
     *        ),
     *        @OA\Response(
     *            response=204,
     *            description="Тип кабинета удален",
     *        )
     *    )
     *
     * @throws \Exception
     */
    public function destroy(CabinetType $cabinetType): Response|JsonResponse
    {
        Gate::authorize('delete', $cabinetType);
        if ($this->service->destroy($cabinetType)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удалении типа кабинета'], 500);
        }
    }
}
