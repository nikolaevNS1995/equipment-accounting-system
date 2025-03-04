<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Http\Resources\Equipment\IndexResource;
use App\Http\Resources\Equipment\ShowResource;
use App\Models\Equipment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $equipments = Equipment::get();
        return IndexResource::collection($equipments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request): ShowResource
    {
        $data = $request->validated();
        $equipment = Equipment::create($data);
        return new ShowResource($equipment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment): ShowResource
    {
        return new ShowResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): ShowResource
    {
        $data = $request->validated();
        $equipment->update($data);
        return new ShowResource($equipment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment): Response
    {
        $equipment->delete();
        return response()->noContent();
    }
}
