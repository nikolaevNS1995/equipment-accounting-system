<?php

namespace App\Http\Controllers;

use App\Http\Requests\FurnitureType\StoreFurnitureTypeRequest;
use App\Http\Requests\FurnitureType\UpdateFurnitureTypeRequest;
use App\Http\Resources\FurnitureType\IndexResource;
use App\Http\Resources\FurnitureType\ShowResource;
use App\Models\FurnitureType;
use App\Services\FurnitureTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="FurnitureType",
 *     description="Управление типами мебели"
 * )
 */
class FurnitureTypeController extends Controller
{
    protected FurnitureTypeService $service;

    public function __construct(FurnitureTypeService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *            path="/api/furniture-types",
     *            summary="Получить список всех типов мебели",
     *            tags={"FurnitureType"},
     *            security={{ "bearerAuth": {} }},
     *            @OA\Response(
     *                response=200,
     *                description="Список типов мебели",
     *                @OA\JsonContent(
     *                    allOf={
     *                        @OA\Schema(ref="#/components/schemas/FurnitureTypeIndexResource")
     *                    }
     *                )
     *            )
     *    )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', FurnitureType::class);
        $furnitureTypes = $this->service->index();
        return IndexResource::collection($furnitureTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *            path="/api/furniture-types",
     *            summary="Создать новый тип мебели",
     *            tags={"FurnitureType"},
     *            security={{ "bearerAuth": {} }},
     *            @OA\RequestBody(
     *                required=true,
     *                @OA\JsonContent(ref="#/components/schemas/StoreFurnitureTypeRequest")
     *            ),
     *            @OA\Response(
     *                response=201,
     *                description="Тип мебели создан",
     *                @OA\JsonContent(ref="#/components/schemas/FurnitureTypeShowResource")
     *            )
     *     )
     * @throws \Exception
     */
    public function store(StoreFurnitureTypeRequest $request): ShowResource
    {
        Gate::authorize('create', FurnitureType::class);
        $data = $request->validated();
        $furnitureType = $this->service->store($data);
        return new ShowResource($furnitureType);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *             path="/api/furniture-types/{id}",
     *             summary="Получить тип мебели",
     *             tags={"FurnitureType"},
     *             security={{ "bearerAuth": {} }},
     *             @OA\Parameter(
     *                 name="id",
     *                 in="path",
     *                 required=true,
     *                 example=1,
     *                 description="ID типа мебели"
     *             ),
     *             @OA\Response(
     *                 response=200,
     *                 description="Тип мебели",
     *                 @OA\JsonContent(
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/FurnitureTypeShowResource")
     *                     }
     *                 )
     *             )
     *     )
     */
    public function show(int $id): ShowResource
    {
        $furnitureType = $this->service->show($id);
        Gate::authorize('view', $furnitureType);
        return new ShowResource($furnitureType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *             path="/api/furniture-types/{furniture-type}",
     *             summary="Обновить тип мебели",
     *             tags={"FurnitureType"},
     *             security={{ "bearerAuth": {} }},
     *             @OA\Parameter(
     *                  name="furniture-type",
     *                  in="path",
     *                  required=true,
     *                  example=1,
     *                  description="ID типа мебели"
     *             ),
     *             @OA\RequestBody(
     *                 required=true,
     *                 @OA\JsonContent(ref="#/components/schemas/UpdateFurnitureTypeRequest")
     *             ),
     *             @OA\Response(
     *                 response=200,
     *                 description="Тип мебель изменен",
     *                 @OA\JsonContent(ref="#/components/schemas/FurnitureTypeShowResource")
     *             )
     *      )
     * @throws \Exception
     */
    public function update(UpdateFurnitureTypeRequest $request, FurnitureType $furnitureType): ShowResource
    {
        Gate::authorize('update', $furnitureType);
        $data = $request->validated();
        $furnitureType = $this->service->update($furnitureType, $data);
        return new ShowResource($furnitureType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *              path="/api/furniture-types/{furniture-type}",
     *              summary="Удалить тип мебели",
     *              tags={"FurnitureType"},
     *              security={{ "bearerAuth": {} }},
     *              @OA\Parameter(
     *                   name="furniture-type",
     *                   in="path",
     *                   required=true,
     *                   example=1,
     *                   description="ID типа мебели"
     *              ),
     *              @OA\Response(
     *                  response=204,
     *                  description="Тип мебели удален",
     *              )
     *      )
     * @throws \Exception
     */
    public function destroy(FurnitureType $furnitureType): Response|JsonResponse
    {
        Gate::authorize('delete', $furnitureType);
        if ($this->service->destroy($furnitureType)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление типа мебели'], 500);
        }
    }
}
