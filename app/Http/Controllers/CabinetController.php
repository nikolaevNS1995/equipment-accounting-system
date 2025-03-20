<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cabinet\StoreCabinetRequest;
use App\Http\Requests\Cabinet\UpdateCabinetRequest;
use App\Http\Resources\Cabinet\IndexResource;
use App\Http\Resources\Cabinet\ShowResource;
use App\Models\Cabinet;
use App\Models\Building;
use App\Services\CabinetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;


/**
 * @OA\Tag(
 *     name="Cabinets",
 *     description="Управление кабинетами"
 * )
 */
class CabinetController extends Controller
{
    protected CabinetService $service;

    public function __construct(CabinetService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *     path="/api/cabinets",
     *     summary="Получить список всех кабинетов",
     *     tags={"Cabinets"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Список кабинетов",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/CabinetIndexResource")
     *             }
     *         )
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Cabinet::class);
        $cabinets = $this->service->index();
        return IndexResource::collection($cabinets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/cabinets",
     *     summary="Создать новый кабинет",
     *     tags={"Cabinets"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCabinetRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Кабинет создан",
     *         @OA\JsonContent(ref="#/components/schemas/CabinetShowResource")
     *     )
     * )
     *
     * @throws \Exception
     */
    public function store(StoreCabinetRequest $request): ShowResource
    {
        Gate::authorize('create', Cabinet::class);
        $data = $request->validated();
        $cabinet = $this->service->store($data);
        return new ShowResource($cabinet);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/cabinets/{id}",
     *      summary="Получить кабинет",
     *      tags={"Cabinets"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          example=1,
     *          description="ID кабинета"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Кабинет",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/CabinetShowResource")
     *              }
     *          )
     *      )
     *  )
     */
    public function show(int $id): ShowResource
    {
        $cabinet = $this->service->show($id);
        Gate::authorize('view', $cabinet);
        return new ShowResource($cabinet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *      path="/api/cabinets/{cabinet}",
     *      summary="Обновить кабинет",
     *      tags={"Cabinets"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *           name="cabinet",
     *           in="path",
     *           required=true,
     *           example=1,
     *           description="ID кабинета"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateCabinetRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Кабинет изменен",
     *          @OA\JsonContent(ref="#/components/schemas/CabinetShowResource")
     *      )
     *  )
     *
     * @throws \Exception
     */
    public function update(UpdateCabinetRequest $request, Cabinet $cabinet): ShowResource
    {
        Gate::authorize('update', $cabinet);
        $data = $request->validated();
        $cabinetUpdated = $this->service->update($cabinet, $data);
        return new ShowResource($cabinetUpdated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *       path="/api/cabinets/{cabinet}",
     *       summary="Удалить кабинет",
     *       tags={"Cabinets"},
     *       security={{ "bearerAuth": {} }},
     *       @OA\Parameter(
     *            name="cabinet",
     *            in="path",
     *            required=true,
     *            example=1,
     *            description="ID кабинета"
     *       ),
     *       @OA\Response(
     *           response=204,
     *           description="Кабинет удален",
     *       )
     *   )
     *
     * @throws \Exception
     */
    public function destroy(Cabinet $cabinet): Response|JsonResponse
    {
        Gate::authorize('delete', $cabinet);
        if ($this->service->destroy($cabinet)) {
            return response()->noContent();
        }
        return response()->json(['message' => 'Ошибка при удалении кабинета'], 500);
    }

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *     path="/api/cabinets/buildings/{building}/floor/{floor}",
     *     summary="Получить список кабинетов по этажам площадки",
     *     tags={"Cabinets"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *             name="building",
     *             in="path",
     *             required=true,
     *             example=1,
     *             description="ID площадки"
     *     ),
     *     @OA\Parameter(
     *             name="floor",
     *             in="path",
     *             required=true,
     *             example=1,
     *             description="Номер этажа"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список кабинетов по этажам площадки",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/CabinetIndexResource")
     *             }
     *         )
     *     )
     * )
     */
    public function getCabinetsByFloor(Building $building, int $floor): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Cabinet::class);
        $cabinets = $this->service->getCabinetsByFloor($building, $floor);
        return IndexResource::collection($cabinets);
    }
}
