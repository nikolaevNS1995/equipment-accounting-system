<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
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
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreUserRequest $request): ShowResource
    {
        Gate::authorize('create', User::class);
        $data = $request->validated();
        $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): ShowResource
    {
        Gate::authorize('view', $user);
        return $this->service->show($user);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateUserRequest $request, User $user): ShowResource
    {
        Gate::authorize('update', $user);
        $data = $request->validated();
        $this->service->update($user, $data);
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
