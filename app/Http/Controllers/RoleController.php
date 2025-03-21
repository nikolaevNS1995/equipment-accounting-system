<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\IndexResource;
use App\Http\Resources\Role\ShowResource;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="Roles",
 *     description="Управление ролями"
 * )
 */
class RoleController extends Controller
{
    protected RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *             path="/api/roles",
     *             summary="Получить список всех ролей",
     *             tags={"Roles"},
     *             security={{ "bearerAuth": {} }},
     *             @OA\Response(
     *                 response=200,
     *                 description="Список ролей",
     *                 @OA\JsonContent(
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/RoleIndexResource")
     *                     }
     *                 )
     *             )
     *     )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Role::class);
        $roles = $this->service->index();
        return IndexResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *             path="/api/roles",
     *             summary="Создать новую роль",
     *             tags={"Roles"},
     *             security={{ "bearerAuth": {} }},
     *             @OA\RequestBody(
     *                 required=true,
     *                 @OA\JsonContent(ref="#/components/schemas/StoreRoleRequest")
     *             ),
     *             @OA\Response(
     *                 response=201,
     *                 description="Роль создана",
     *                 @OA\JsonContent(ref="#/components/schemas/RoleShowResource")
     *             )
     *      )
     * @throws \Exception
     */
    public function store(StoreRoleRequest $request): ShowResource
    {
        Gate::authorize('create', Role::class);
        $data = $request->validated();
        $role = $this->service->store($data);
        return new ShowResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *              path="/api/roles/{id}",
     *              summary="Получить роль",
     *              tags={"Roles"},
     *              security={{ "bearerAuth": {} }},
     *              @OA\Parameter(
     *                  name="id",
     *                  in="path",
     *                  required=true,
     *                  example=1,
     *                  description="ID роли"
     *              ),
     *              @OA\Response(
     *                  response=200,
     *                  description="Роль",
     *                  @OA\JsonContent(
     *                      allOf={
     *                          @OA\Schema(ref="#/components/schemas/RoleShowResource")
     *                      }
     *                  )
     *              )
     *      )
     */
    public function show(int $id): ShowResource
    {
        $role = $this->service->show($id);
        Gate::authorize('view', $role);
        return new ShowResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *              path="/api/roles/{role}",
     *              summary="Обновить роль",
     *              tags={"Roles"},
     *              security={{ "bearerAuth": {} }},
     *              @OA\Parameter(
     *                   name="role",
     *                   in="path",
     *                   required=true,
     *                   example=1,
     *                   description="ID роли"
     *              ),
     *              @OA\RequestBody(
     *                  required=true,
     *                  @OA\JsonContent(ref="#/components/schemas/UpdateRoleRequest")
     *              ),
     *              @OA\Response(
     *                  response=200,
     *                  description="Роль изменена",
     *                  @OA\JsonContent(ref="#/components/schemas/RoleShowResource")
     *              )
     *       )
     * @throws \Exception
     */
    public function update(UpdateRoleRequest $request, Role $role): ShowResource
    {
        Gate::authorize('update', $role);
        $data = $request->validated();
        $role = $this->service->update($role, $data);
        return new ShowResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *               path="/api/roles/{role}",
     *               summary="Удалить роль",
     *               tags={"Roles"},
     *               security={{ "bearerAuth": {} }},
     *               @OA\Parameter(
     *                    name="role",
     *                    in="path",
     *                    required=true,
     *                    example=1,
     *                    description="ID роли"
     *               ),
     *               @OA\Response(
     *                   response=204,
     *                   description="Роль удалена",
     *               )
     *       )
     * @throws \Exception
     */
    public function destroy(Role $role): Response|JsonResponse
    {
        Gate::authorize('delete', $role);
        if ($this->service->destroy($role)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление роли'], 500);
        }
    }
}
