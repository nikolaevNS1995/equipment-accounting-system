<?php

namespace App\Http\Controllers;

use App\Http\Requests\CabinetType\StoreCabinetTypeRequest;
use App\Http\Requests\CabinetType\UpdateCabinetTypeRequest;
use App\Http\Resources\CabinetType\IndexResource;
use App\Http\Resources\CabinetType\ShowResource;
use App\Models\CabinetType;
use App\Services\CabinetTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CabinetTypeController extends Controller
{
    protected CabinetTypeService $service;

    public function __construct(CabinetTypeService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', CabinetType::class);
        $cabinetTypes = $this->service->index();
        return IndexResource::collection($cabinetTypes);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreCabinetTypeRequest $request): ShowResource
    {
        Gate::authorize('create', CabinetType::class);
        $data = $request->validated();
        $cabinetType = $this->service->store($data);
        return new ShowResource($cabinetType);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ShowResource
    {
        $cabinetType = $this->service->show($id);
        Gate::authorize('view', $cabinetType);
        return new ShowResource($cabinetType);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateCabinetTypeRequest $request, CabinetType $cabinetType): ShowResource
    {
        Gate::authorize('update', $cabinetType);
        $data = $request->validated();
        $cabinetTypeUpdated = $this->service->update($cabinetType, $data);
        return new ShowResource($cabinetTypeUpdated);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(CabinetType $cabinetType): Response|JsonResponse
    {
        Gate::authorize('delete', $cabinetType);
        if ($this->service->destroy($cabinetType)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удалении типа кабинета'], 500);
        }
    }
}
