<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\IndexResource;
use App\Http\Resources\User\ShowResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Управление пользователями"
 * )
 */
class UserController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *              path="/api/users",
     *              summary="Получить список всех пользователей",
     *              tags={"Users"},
     *              security={{ "bearerAuth": {} }},
     *              @OA\Response(
     *                  response=200,
     *                  description="Список пользователей",
     *                  @OA\JsonContent(
     *                      allOf={
     *                          @OA\Schema(ref="#/components/schemas/UserIndexResource")
     *                      }
     *                  )
     *              )
     *      )
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', User::class);
        $users = $this->service->index();
        return IndexResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *              path="/api/users",
     *              summary="Создать нового пользователя",
     *              tags={"Users"},
     *              security={{ "bearerAuth": {} }},
     *              @OA\RequestBody(
     *                  required=true,
     *                  @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
     *              ),
     *              @OA\Response(
     *                  response=201,
     *                  description="Пользователь создан",
     *                  @OA\JsonContent(ref="#/components/schemas/UserShowResource")
     *              )
     *       )
     * @throws \Exception
     */
    public function store(StoreUserRequest $request): ShowResource
    {
        Gate::authorize('create', User::class);
        $data = $request->validated();
        $user = $this->service->store($data);
        return new ShowResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *               path="/api/users/{id}",
     *               summary="Получить пользователя",
     *               tags={"Users"},
     *               security={{ "bearerAuth": {} }},
     *               @OA\Parameter(
     *                   name="id",
     *                   in="path",
     *                   required=true,
     *                   example=1,
     *                   description="ID пользователя"
     *               ),
     *               @OA\Response(
     *                   response=200,
     *                   description="Пользователь",
     *                   @OA\JsonContent(
     *                       allOf={
     *                           @OA\Schema(ref="#/components/schemas/UserShowResource")
     *                       }
     *                   )
     *               )
     *       )
     */
    public function show(int $id): ShowResource
    {
        $user = $this->service->show($id);
        Gate::authorize('view', $user);
        return new ShowResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *               path="/api/users/{user}",
     *               summary="Обновить пользователя",
     *               tags={"Users"},
     *               security={{ "bearerAuth": {} }},
     *               @OA\Parameter(
     *                    name="user",
     *                    in="path",
     *                    required=true,
     *                    example=1,
     *                    description="ID пользователя"
     *               ),
     *               @OA\RequestBody(
     *                   required=true,
     *                   @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
     *               ),
     *               @OA\Response(
     *                   response=200,
     *                   description="Пользователь изменен",
     *                   @OA\JsonContent(ref="#/components/schemas/UserShowResource")
     *               )
     *        )
     * @throws \Exception
     */
    public function update(UpdateUserRequest $request, User $user): ShowResource
    {
        Gate::authorize('update', $user);
        $data = $request->validated();
        $user = $this->service->update($user, $data);
        return new ShowResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *                path="/api/users/{user}",
     *                summary="Удалить пользователя",
     *                tags={"Users"},
     *                security={{ "bearerAuth": {} }},
     *                @OA\Parameter(
     *                     name="user",
     *                     in="path",
     *                     required=true,
     *                     example=1,
     *                     description="ID пользователя"
     *                ),
     *                @OA\Response(
     *                    response=204,
     *                    description="Пользователь удален",
     *                )
     *        )
     * @throws \Exception
     */
    public function destroy(User $user): Response|JsonResponse
    {
        Gate::authorize('delete', $user);
        if ($this->service->destroy($user)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление пользователя'], 500);
        }
    }
}
