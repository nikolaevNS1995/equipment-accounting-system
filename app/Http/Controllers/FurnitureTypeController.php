<?php

namespace App\Http\Controllers;

use App\Http\Requests\FurnitureType\StoreFurnitureTypeRequest;
use App\Http\Requests\FurnitureType\UpdateFurnitureTypeRequest;
use App\Http\Resources\FurnitureType\IndexResource;
use App\Http\Resources\FurnitureType\ShowResource;
use App\Models\FurnitureType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FurnitureTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $furnitureTypes = FurnitureType::get();
        return IndexResource::collection($furnitureTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFurnitureTypeRequest $request): ShowResource
    {
        $data = $request->validated();
        $furnitureType = FurnitureType::create($data);
        return new ShowResource($furnitureType);
    }

    /**
     * Display the specified resource.
     */
    public function show(FurnitureType $furnitureType): ShowResource
    {
        return new ShowResource($furnitureType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFurnitureTypeRequest $request, FurnitureType $furnitureType): ShowResource
    {
        $data = $request->validated();
        $furnitureType->update($data);
        return new ShowResource($furnitureType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FurnitureType $furnitureType): Response
    {
        $furnitureType->delete();
        return response()->noContent();
    }
}
