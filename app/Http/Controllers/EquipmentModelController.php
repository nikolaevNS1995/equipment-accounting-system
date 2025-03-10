<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentModel\StoreEquipmentModelRequest;
use App\Http\Requests\EquipmentModel\UpdateEquipmentModelRequest;
use App\Http\Resources\EquipmentModel\IndexResource;
use App\Http\Resources\EquipmentModel\ShowResource;
use App\Models\EquipmentModel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentModel::class);
        $equipmentModels = EquipmentModel::get();
        return IndexResource::collection($equipmentModels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentModelRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentModel::class);
        $data = $request->validated();
        $equipmentModel = EquipmentModel::create($data);
        return new ShowResource($equipmentModel);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentModel $equipmentModel): ShowResource
    {
        Gate::authorize('view', $equipmentModel);
        return new ShowResource($equipmentModel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentModelRequest $request, EquipmentModel $equipmentModel): ShowResource
    {
        Gate::authorize('update', $equipmentModel);
        $data = $request->validated();
        $equipmentModel->update($data);
        return new ShowResource($equipmentModel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentModel $equipmentModel): Response
    {
        Gate::authorize('delete', $equipmentModel);
        $equipmentModel->delete();
        return response()->noContent();
    }
}
