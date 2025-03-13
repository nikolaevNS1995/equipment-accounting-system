<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentBrand\StoreEquipmentBrandRequest;
use App\Http\Requests\EquipmentBrand\UpdateEquipmentBrandRequest;
use App\Http\Resources\EquipmentBrand\IndexResource;
use App\Http\Resources\EquipmentBrand\ShowResource;
use App\Models\EquipmentBrand;
use App\Services\EquipmentBrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EquipmentBrandController extends Controller
{
    protected EquipmentBrandService $service;

    public function __construct(EquipmentBrandService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', EquipmentBrand::class);
        $equipmentBrands = $this->service->index();
        return IndexResource::collection($equipmentBrands);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreEquipmentBrandRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentBrand::class);
        $data = $request->validated();
        $equipmentBrand = $this->service->store($data);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ShowResource
    {
        $equipmentBrand = $this->service->show($id);
        Gate::authorize('view', $equipmentBrand);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateEquipmentBrandRequest $request, EquipmentBrand $equipmentBrand): ShowResource
    {
        Gate::authorize('update', $equipmentBrand);
        $data = $request->validated();
        $equipmentBrand = $this->service->update($equipmentBrand, $data);
        return new ShowResource($equipmentBrand);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(EquipmentBrand $equipmentBrand): Response|JsonResponse
    {
        Gate::authorize('delete', $equipmentBrand);
        if ($this->service->destroy($equipmentBrand)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление бренда оборудования']);
        }
    }
}
