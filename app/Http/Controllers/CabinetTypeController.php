<?php

namespace App\Http\Controllers;

use App\Http\Requests\CabinetType\StoreCabinetTypeRequest;
use App\Http\Requests\CabinetType\UpdateCabinetTypeRequest;
use App\Http\Resources\CabinetType\IndexResource;
use App\Http\Resources\CabinetType\ShowResource;
use App\Models\CabinetType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CabinetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', CabinetType::class);
        $cabinetTypes = CabinetType::get();
        return IndexResource::collection($cabinetTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCabinetTypeRequest $request): ShowResource
    {
        Gate::authorize('create', CabinetType::class);
        $data = $request->validated();
        $cabinetType = CabinetType::create($data);
        return new ShowResource($cabinetType);
    }

    /**
     * Display the specified resource.
     */
    public function show(CabinetType $cabinetType): ShowResource
    {
        Gate::authorize('view', $cabinetType);
        return new ShowResource($cabinetType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCabinetTypeRequest $request, CabinetType $cabinetType): ShowResource
    {
        Gate::authorize('update', $cabinetType);
        $data = $request->validated();
        $cabinetType->update($data);
        return new ShowResource($cabinetType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CabinetType $cabinetType): Response
    {
        Gate::authorize('delete', $cabinetType);
        $cabinetType->delete();
        return response()->noContent();
    }
}
