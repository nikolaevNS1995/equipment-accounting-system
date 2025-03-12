<?php

namespace App\Http\Controllers;

use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Resources\Building\IndexResource;
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
        $buildings = $this->service->index();
        return IndexResource::collection($buildings);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreBuildingRequest $request): ShowResource
    {
        Gate::authorize('create', Building::class);
        $data = $request->validated();
        $building = $this->service->store($data);
        return new ShowResource($building);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ShowResource
    {
        $building = $this->service->show($id);
        Gate::authorize('view', $building);
        return new ShowResource($building);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateBuildingRequest $request, Building $building): ShowResource
    {
        Gate::authorize('update', $building);
        $data = $request->validated();
        $buildingUpdated = $this->service->update($building, $data);
        return new ShowResource($buildingUpdated);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
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
