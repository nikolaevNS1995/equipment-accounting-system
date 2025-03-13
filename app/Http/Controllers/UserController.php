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

class UserController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', User::class);
        $users = $this->service->index();
        return IndexResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function show(int $id): ShowResource
    {
        $user = $this->service->show($id);
        Gate::authorize('view', $user);
        return new ShowResource($user);
    }

    /**
     * Update the specified resource in storage.
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
