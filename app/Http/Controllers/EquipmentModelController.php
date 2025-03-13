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
        $equipmentModels = $this->service->index();
        return IndexResource::collection($equipmentModels);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreEquipmentModelRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentModel::class);
        $data = $request->validated();
        $equipmentModel = $this->service->store($data);
        return new ShowResource($equipmentModel);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ShowResource
    {
        $equipmentModel = $this->service->show($id);
        Gate::authorize('view', $equipmentModel);
        return new ShowResource($equipmentModel);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateEquipmentModelRequest $request, EquipmentModel $equipmentModel): ShowResource
    {
        Gate::authorize('update', $equipmentModel);
        $data = $request->validated();
        $equipmentModel = $this->service->update($equipmentModel, $data);
        return new ShowResource($equipmentModel);
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
