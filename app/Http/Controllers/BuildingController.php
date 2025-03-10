<?php

namespace App\Http\Controllers;

use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Resources\Building\IndexResource;
use App\Http\Resources\Building\ShowResource;
use App\Models\Building;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Building::class);
        $buildings = Building::get();
        return IndexResource::collection($buildings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request): ShowResource
    {
        Gate::authorize('create', Building::class);
        $data = $request->validated();
        $building = Building::create($data);

        return new ShowResource($building);
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building): ShowResource
    {
        Gate::authorize('view', $building);
        return new ShowResource($building);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building): ShowResource
    {
        Gate::authorize('update', $building);
        $data = $request->validated();
        $building->update($data);
        return new ShowResource($building);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building): Response
    {
        Gate::authorize('delete', $building);
        $building->delete();
        return response()->noContent();
    }
}
