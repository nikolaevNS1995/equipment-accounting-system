<?php

namespace App\Http\Controllers;

use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Resources\Building\ShowResource;
use App\Models\Building;
use App\Services\BuildingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class BuildingController extends Controller
{
    protected BuildingService $service;

    public function __construct(BuildingService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Building::class);
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request): ShowResource
    {
        Gate::authorize('create', Building::class);
        $data = $request->validated();
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building): ShowResource
    {
        Gate::authorize('view', $building);
        return $this->service->show($building);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building): ShowResource
    {
        Gate::authorize('update', $building);
        $data = $request->validated();
        return $this->service->update($building, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building): Response|JsonResponse
    {
        Gate::authorize('delete', $building);
        if ($this->service->destroy($building)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление площадки'], 500);
        }
    }
}
