<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Http\Resources\Equipment\IndexResource;
use App\Http\Resources\Equipment\ShowResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentController extends Controller
{
    protected EquipmentService $service;

    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Equipment::class);
        $equipments = $this->service->index();
        return IndexResource::collection($equipments);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreEquipmentRequest $request): ShowResource
    {
        Gate::authorize('create', Equipment::class);
        $data = $request->validated();
        $equipment = $this->service->store($data);
        return new ShowResource($equipment);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ShowResource
    {
        $equipment = $this->service->show($id);
        Gate::authorize('view', $equipment);
        return new ShowResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): ShowResource
    {
        Gate::authorize('update', $equipment);
        $data = $request->validated();
        $equipment = $this->service->update($equipment, $data);
        return new ShowResource($equipment);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(Equipment $equipment): Response|JsonResponse
    {
        Gate::authorize('delete', $equipment);
        if ($this->service->destroy($equipment)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление оборудования']);
        }
    }
}
