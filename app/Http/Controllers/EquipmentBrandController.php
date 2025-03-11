<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentBrand\StoreEquipmentBrandRequest;
use App\Http\Requests\EquipmentBrand\UpdateEquipmentBrandRequest;
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
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreEquipmentBrandRequest $request): ShowResource
    {
        Gate::authorize('create', EquipmentBrand::class);
        $data = $request->validated();
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentBrand $equipmentBrand): ShowResource
    {
        Gate::authorize('view', $equipmentBrand);
        return $this->service->show($equipmentBrand);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateEquipmentBrandRequest $request, EquipmentBrand $equipmentBrand): ShowResource
    {
        Gate::authorize('update', $equipmentBrand);
        $data = $request->validated();
        return $this->service->update($equipmentBrand, $data);
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
