<?php

namespace App\Http\Controllers;

use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Resources\Building\IndexResource;
use App\Http\Resources\Building\ShowResource;
use App\Models\Building;
use App\Services\BuildingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="Buildings",
 *     description="Управление площадками"
 * )
 */
class BuildingController extends Controller
{
    protected BuildingService $service;

    public function __construct(BuildingService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *      path="/api/buildings",
     *      summary="Получить список всех площадок",
     *      tags={"Buildings"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Список площадок",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/BuildingIndexResource")
     *              }
     *          )
     *      )
     *  )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Building::class);
        $buildings = $this->service->index();
        return IndexResource::collection($buildings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/buildings",
     *      summary="Создать новую площадку",
     *      tags={"Buildings"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreBuildingRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Площадка создан",
     *          @OA\JsonContent(ref="#/components/schemas/BuildingShowResource")
     *      )
     *  )
     * @throws \Exception
     */
    public function store(StoreBuildingRequest $request): ShowResource
    {
        Gate::authorize('create', Building::class);
        $data = $request->validated();
        $building = $this->service->store($data);
        return new ShowResource($building);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *       path="/api/buildings/{id}",
     *       summary="Получить площадку",
     *       tags={"Buildings"},
     *       security={{ "bearerAuth": {} }},
     *       @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           example=1,
     *           description="ID площадки"
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Площадка",
     *           @OA\JsonContent(
     *               allOf={
     *                   @OA\Schema(ref="#/components/schemas/BuildingShowResource")
     *               }
     *           )
     *       )
     *   )
     */
    public function show(int $id): ShowResource
    {
        $building = $this->service->show($id);
        Gate::authorize('view', $building);
        return new ShowResource($building);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *       path="/api/buildings/{building}",
     *       summary="Обновить площадку",
     *       tags={"Buildings"},
     *       security={{ "bearerAuth": {} }},
     *       @OA\Parameter(
     *            name="building",
     *            in="path",
     *            required=true,
     *            example=1,
     *            description="ID площадки"
     *       ),
     *       @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/UpdateBuildingRequest")
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Площадка изменена",
     *           @OA\JsonContent(ref="#/components/schemas/BuildingShowResource")
     *       )
     *   )
     * @throws \Exception
     */
    public function update(UpdateBuildingRequest $request, Building $building): ShowResource
    {
        Gate::authorize('update', $building);
        $data = $request->validated();
        $buildingUpdated = $this->service->update($building, $data);
        return new ShowResource($buildingUpdated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *        path="/api/buildings/{building}",
     *        summary="Удалить площадку",
     *        tags={"Buildings"},
     *        security={{ "bearerAuth": {} }},
     *        @OA\Parameter(
     *             name="building",
     *             in="path",
     *             required=true,
     *             example=1,
     *             description="ID площадки"
     *        ),
     *        @OA\Response(
     *            response=204,
     *            description="Площадка удалена",
     *        )
     *    )
     * @throws \Exception
     */
    public function destroy(Building $building): Response|JsonResponse
    {
        Gate::authorize('delete', $building);
        if ($this->service->destroy($building)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление площадки'], 500);
        }
    }
}
