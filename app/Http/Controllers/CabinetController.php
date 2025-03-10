<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cabinet\StoreCabinetRequest;
use App\Http\Requests\Cabinet\UpdateCabinetRequest;
use App\Http\Resources\Cabinet\IndexResource;
use App\Http\Resources\Cabinet\ShowResource;
use App\Models\Cabinet;
use App\Models\Building;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CabinetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Cabinet::class);
        $cabinets = Cabinet::get();
        return IndexResource::collection($cabinets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCabinetRequest $request): ShowResource
    {
        Gate::authorize('create', Cabinet::class);
        $data = $request->validated();
        $cabinet = Cabinet::create($data);
        return new ShowResource($cabinet);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabinet $cabinet): ShowResource
    {
        Gate::authorize('view', $cabinet);
        return new ShowResource($cabinet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCabinetRequest $request, Cabinet $cabinet): ShowResource
    {
        Gate::authorize('update', $cabinet);
        $data = $request->validated();
        $cabinet->update($data);
        return new ShowResource($cabinet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabinet $cabinet): Response
    {
        Gate::authorize('delete', $cabinet);
        $cabinet->delete();
        return response()->noContent();
    }

    public function getCabinetsByFloor(Building $building, int $floor): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Cabinet::class);
        $cabinets = Cabinet::where('building_id', $building->id)->where('floor', $floor)->get();
        return IndexResource::collection($cabinets);
    }
}
