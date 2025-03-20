<?php

namespace App\Http\Controllers;

use App\Http\Requests\Furniture\StoreFurnitureRequest;
use App\Http\Requests\Furniture\UpdateFurnitureRequest;
use App\Http\Resources\Furniture\IndexResource;
use App\Http\Resources\Furniture\ShowResource;
use App\Models\Furniture;
use App\Services\FurnitureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="Furniture",
 *     description="Управление мебелью"
 * )
 */
class FurnitureController extends Controller
{
    protected FurnitureService $service;

    public function __construct(FurnitureService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *           path="/api/furnitures",
     *           summary="Получить список всей мебели",
     *           tags={"Furniture"},
     *           security={{ "bearerAuth": {} }},
     *           @OA\Response(
     *               response=200,
     *               description="Список мебели",
     *               @OA\JsonContent(
     *                   allOf={
     *                       @OA\Schema(ref="#/components/schemas/FurnitureIndexResource")
     *                   }
     *               )
     *           )
     *   )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Furniture::class);
        $furniture = $this->service->index();
        return IndexResource::collection($furniture);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *           path="/api/furnitures",
     *           summary="Создать новую мебель",
     *           tags={"Furniture"},
     *           security={{ "bearerAuth": {} }},
     *           @OA\RequestBody(
     *               required=true,
     *               @OA\JsonContent(ref="#/components/schemas/StoreFurnitureRequest")
     *           ),
     *           @OA\Response(
     *               response=201,
     *               description="Мебель создана",
     *               @OA\JsonContent(ref="#/components/schemas/FurnitureShowResource")
     *           )
     *    )
     * @throws \Exception
     */
    public function store(StoreFurnitureRequest $request): ShowResource
    {
        Gate::authorize('create', Furniture::class);
        $data = $request->validated();
        $furniture = $this->service->store($data);
        return new ShowResource($furniture);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *            path="/api/furnitures/{id}",
     *            summary="Получить мебель",
     *            tags={"Furniture"},
     *            security={{ "bearerAuth": {} }},
     *            @OA\Parameter(
     *                name="id",
     *                in="path",
     *                required=true,
     *                example=1,
     *                description="ID мебели"
     *            ),
     *            @OA\Response(
     *                response=200,
     *                description="Мебель",
     *                @OA\JsonContent(
     *                    allOf={
     *                        @OA\Schema(ref="#/components/schemas/FurnitureShowResource")
     *                    }
     *                )
     *            )
     *    )
     */
    public function show(int $id): ShowResource
    {
        $furniture = $this->service->show($id);
        Gate::authorize('view', $furniture);
        return new ShowResource($furniture);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *            path="/api/furnitures/{furniture}",
     *            summary="Обновить мебель",
     *            tags={"Furniture"},
     *            security={{ "bearerAuth": {} }},
     *            @OA\Parameter(
     *                 name="furniture",
     *                 in="path",
     *                 required=true,
     *                 example=1,
     *                 description="ID мебели"
     *            ),
     *            @OA\RequestBody(
     *                required=true,
     *                @OA\JsonContent(ref="#/components/schemas/UpdateFurnitureRequest")
     *            ),
     *            @OA\Response(
     *                response=200,
     *                description="Мебель изменена",
     *                @OA\JsonContent(ref="#/components/schemas/FurnitureShowResource")
     *            )
     *     )
     * @throws \Exception
     */
    public function update(UpdateFurnitureRequest $request, Furniture $furniture): ShowResource
    {
        Gate::authorize('update', $furniture);
        $data = $request->validated();
        $furniture = $this->service->update($furniture, $data);
        return new ShowResource($furniture);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *             path="/api/furnitures/{furniture}",
     *             summary="Удалить мебель",
     *             tags={"Furniture"},
     *             security={{ "bearerAuth": {} }},
     *             @OA\Parameter(
     *                  name="furniture",
     *                  in="path",
     *                  required=true,
     *                  example=1,
     *                  description="ID мебели"
     *             ),
     *             @OA\Response(
     *                 response=204,
     *                 description="Мебель удалена",
     *             )
     *     )
     * @throws \Exception
     */
    public function destroy(Furniture $furniture): Response|JsonResponse
    {
        Gate::authorize('delete', $furniture);
        if ($this->service->destroy($furniture)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление мебели']);
        }
    }
}
