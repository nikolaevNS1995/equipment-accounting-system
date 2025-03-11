<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentType\StoreEquipmentTypeRequest;
use App\Http\Requests\EquipmentType\UpdateEquipmentTypeRequest;
use App\Http\Resources\EquipmentType\IndexResource;
use App\Http\Resources\EquipmentType\ShowResource;
use App\Models\EquipmentType;
use App\Services\EquipmentTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentTypeController extends Controller
{
    protected EquipmentTypeService $service;

    public function __construct(EquipmentTypeService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentType::class);
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreEquipmentTypeRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentType::class);
        $data = $request->validated();
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentType $equipmentType): ShowResource
    {
        Gate::authorize('view', $equipmentType);
        return $this->service->show($equipmentType);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipmentType): ShowResource
    {
        Gate::authorize('update', $equipmentType);
        $data = $request->validated();
        return $this->service->update($equipmentType, $data);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(EquipmentType $equipmentType): Response|JsonResponse
    {
        Gate::authorize('delete', $equipmentType);
        if ($this->service->destroy($equipmentType)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление типа оборудования'], 500);
        }
    }
}
