<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Http\Resources\Equipment\IndexResource;
use App\Http\Resources\Equipment\ShowResource;
use App\Models\Equipment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Equipment::class);
        $equipments = Equipment::get();
        return IndexResource::collection($equipments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request): ShowResource
    {
        Gate::authorize('create', Equipment::class);
        $data = $request->validated();
        $equipment = Equipment::create($data);
        return new ShowResource($equipment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment): ShowResource
    {
        Gate::authorize('view', $equipment);
        return new ShowResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): ShowResource
    {
        Gate::authorize('update', $equipment);
        $data = $request->validated();
        $equipment->update($data);
        return new ShowResource($equipment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment): Response
    {
        Gate::authorize('delete', $equipment);
        $equipment->delete();
        return response()->noContent();
    }
}
