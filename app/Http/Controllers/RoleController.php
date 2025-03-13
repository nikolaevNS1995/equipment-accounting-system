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

class RoleController extends Controller
{
    protected RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Role::class);
        $roles = $this->service->index();
        return IndexResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function show(int $id): ShowResource
    {
        $role = $this->service->show($id);
        Gate::authorize('view', $role);
        return new ShowResource($role);
    }

    /**
     * Update the specified resource in storage.
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
