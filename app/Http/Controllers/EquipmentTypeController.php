<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentType\StoreEquipmentTypeRequest;
use App\Http\Requests\EquipmentType\UpdateEquipmentTypeRequest;
use App\Http\Resources\EquipmentType\IndexResource;
use App\Http\Resources\EquipmentType\ShowResource;
use App\Models\EquipmentType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentType::class);
        $equipmentTypes = EquipmentType::get();
        return IndexResource::collection($equipmentTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentTypeRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentType::class);
        $data = $request->validated();
        $equipmentType = EquipmentType::create($data);
        return new ShowResource($equipmentType);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentType $equipmentType): ShowResource
    {
        Gate::authorize('view', $equipmentType);
        return new ShowResource($equipmentType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipmentType): ShowResource
    {
        Gate::authorize('update', $equipmentType);
        $data = $request->validated();
        $equipmentType->update($data);
        return new ShowResource($equipmentType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentType $equipmentType): Response
    {
        Gate::authorize('delete', $equipmentType);
        $equipmentType->delete();
        return response()->noContent();
    }
}
