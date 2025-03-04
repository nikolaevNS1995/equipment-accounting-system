<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentModel\StoreEquipmentModelRequest;
use App\Http\Requests\EquipmentModel\UpdateEquipmentModelRequest;
use App\Http\Resources\EquipmentModel\IndexResource;
use App\Http\Resources\EquipmentModel\ShowResource;
use App\Models\EquipmentModel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EquipmentModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $equipmentModels = EquipmentModel::get();
        return IndexResource::collection($equipmentModels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentModelRequest $request): ShowResource
    {
        $data = $request->validated();
        $equipmentModel = EquipmentModel::create($data);
        return new ShowResource($equipmentModel);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentModel $equipmentModel): ShowResource
    {
        return new ShowResource($equipmentModel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentModelRequest $request, EquipmentModel $equipmentModel): ShowResource
    {
        $data = $request->validated();
        $equipmentModel->update($data);
        return new ShowResource($equipmentModel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentModel $equipmentModel): Response
    {
        $equipmentModel->delete();
        return response()->noContent();
    }
}
