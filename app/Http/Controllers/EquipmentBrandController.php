<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentBrand\StoreEquipmentBrandRequest;
use App\Http\Requests\EquipmentBrand\UpdateEquipmentBrandRequest;
use App\Http\Resources\EquipmentBrand\IndexResource;
use App\Http\Resources\EquipmentBrand\ShowResource;
use App\Models\EquipmentBrand;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentBrand::class);
        $equipmentBrands = EquipmentBrand::get();
        return IndexResource::collection($equipmentBrands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentBrandRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentBrand::class);
        $data = $request->validated();
        $equipmentBrand = EquipmentBrand::create($data);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentBrand $equipmentBrand): ShowResource
    {
        Gate::authorize('view', $equipmentBrand);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentBrandRequest $request, EquipmentBrand $equipmentBrand): ShowResource
    {
        Gate::authorize('update', $equipmentBrand);
        $data = $request->validated();
        $equipmentBrand->update($data);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentBrand $equipmentBrand): Response
    {
        Gate::authorize('delete', $equipmentBrand);
        $equipmentBrand->delete();
        return response()->noContent();
    }
}
