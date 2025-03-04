<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentType\StoreEquipmentTypeRequest;
use App\Http\Requests\EquipmentType\UpdateEquipmentTypeRequest;
use App\Http\Resources\EquipmentType\IndexResource;
use App\Http\Resources\EquipmentType\ShowResource;
use App\Models\EquipmentType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $equipmentTypes = EquipmentType::get();
        return IndexResource::collection($equipmentTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentTypeRequest $request): ShowResource
    {
        $data = $request->validated();
        $equipmentType = EquipmentType::create($data);
        return new ShowResource($equipmentType);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentType $equipmentType): ShowResource
    {
        return new ShowResource($equipmentType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipmentType): ShowResource
    {
        $data = $request->validated();
        $equipmentType->update($data);
        return new ShowResource($equipmentType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentType $equipmentType): Response
    {
        $equipmentType->delete();
        return response()->noContent();
    }
}
