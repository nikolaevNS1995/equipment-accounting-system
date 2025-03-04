<?php

namespace App\Http\Controllers;

use App\Http\Requests\CabinetType\StoreCabinetTypeRequest;
use App\Http\Requests\CabinetType\UpdateCabinetTypeRequest;
use App\Http\Resources\CabinetType\IndexResource;
use App\Http\Resources\CabinetType\ShowResource;
use App\Models\CabinetType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CabinetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $cabinetTypes = CabinetType::get();
        return IndexResource::collection($cabinetTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCabinetTypeRequest $request): ShowResource
    {
        $data = $request->validated();
        $cabinetType = CabinetType::create($data);
        return new ShowResource($cabinetType);
    }

    /**
     * Display the specified resource.
     */
    public function show(CabinetType $cabinetType): ShowResource
    {
        return new ShowResource($cabinetType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCabinetTypeRequest $request, CabinetType $cabinetType): ShowResource
    {
        $data = $request->validated();
        $cabinetType->update($data);
        return new ShowResource($cabinetType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CabinetType $cabinetType): Response
    {
        $cabinetType->delete();
        return response()->noContent();
    }
}
