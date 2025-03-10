<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\IndexResource;
use App\Http\Resources\Role\ShowResource;
use App\Models\Role;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Role::class);
        $roles = Role::get();
        return IndexResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): ShowResource
    {
        Gate::authorize('create', Role::class);
        $data = $request->validated();
        $role = Role::create($data);
        return new ShowResource($role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): ShowResource
    {
        Gate::authorize('view', $role);
        return new ShowResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): ShowResource
    {
        Gate::authorize('update', $role);
        $data = $request->validated();
        $role->update($data);
        return new ShowResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): Response
    {
        Gate::authorize('delete', $role);
        $role->delete();
        return response()->noContent();
    }
}
