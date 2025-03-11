<?php

namespace App\Http\Controllers;

use App\Http\Requests\FurnitureType\StoreFurnitureTypeRequest;
use App\Http\Requests\FurnitureType\UpdateFurnitureTypeRequest;
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
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreFurnitureTypeRequest $request): ShowResource
    {
        Gate::authorize('create', FurnitureType::class);
        $data = $request->validated();
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(FurnitureType $furnitureType): ShowResource
    {
        Gate::authorize('view', $furnitureType);
        return $this->service->show($furnitureType);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateFurnitureTypeRequest $request, FurnitureType $furnitureType): ShowResource
    {
        Gate::authorize('update', $furnitureType);
        $data = $request->validated();
        return $this->service->update($furnitureType, $data);
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
