<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentModel\StoreEquipmentModelRequest;
use App\Http\Requests\EquipmentModel\UpdateEquipmentModelRequest;
use App\Http\Resources\EquipmentModel\IndexResource;
use App\Http\Resources\EquipmentModel\ShowResource;
use App\Models\EquipmentModel;
use App\Services\EquipmentModelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentModelController extends Controller
{
    protected EquipmentModelService $service;

    public function __construct(EquipmentModelService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentModel::class);
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreEquipmentModelRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentModel::class);
        $data = $request->validated();
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentModel $equipmentModel): ShowResource
    {
        Gate::authorize('view', $equipmentModel);
        return $this->service->show($equipmentModel);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateEquipmentModelRequest $request, EquipmentModel $equipmentModel): ShowResource
    {
        Gate::authorize('update', $equipmentModel);
        $data = $request->validated();
       return $this->service->update($equipmentModel, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentModel $equipmentModel): Response|JsonResponse
    {
        Gate::authorize('delete', $equipmentModel);
        if ($this->service->destroy($equipmentModel)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление модели оборудования'], 500);
        }
    }
}
