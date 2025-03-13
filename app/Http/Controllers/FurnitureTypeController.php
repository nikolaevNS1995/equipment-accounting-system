<?php

namespace App\Http\Controllers;

use App\Http\Requests\FurnitureType\StoreFurnitureTypeRequest;
use App\Http\Requests\FurnitureType\UpdateFurnitureTypeRequest;
use App\Http\Resources\FurnitureType\IndexResource;
use App\Http\Resources\FurnitureType\ShowResource;
use App\Models\FurnitureType;
use App\Services\FurnitureTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class FurnitureTypeController extends Controller
{
    protected FurnitureTypeService $service;

    public function __construct(FurnitureTypeService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', FurnitureType::class);
        $furnitureTypes = $this->service->index();
        return IndexResource::collection($furnitureTypes);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreFurnitureTypeRequest $request): ShowResource
    {
        Gate::authorize('create', FurnitureType::class);
        $data = $request->validated();
        $furnitureType = $this->service->store($data);
        return new ShowResource($furnitureType);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ShowResource
    {
        $furnitureType = $this->service->show($id);
        Gate::authorize('view', $furnitureType);
        return new ShowResource($furnitureType);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateFurnitureTypeRequest $request, FurnitureType $furnitureType): ShowResource
    {
        Gate::authorize('update', $furnitureType);
        $data = $request->validated();
        $furnitureType = $this->service->update($furnitureType, $data);
        return new ShowResource($furnitureType);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(FurnitureType $furnitureType): Response|JsonResponse
    {
        Gate::authorize('delete', $furnitureType);
        if ($this->service->destroy($furnitureType)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление типа мебели'], 500);
        }
    }
}
