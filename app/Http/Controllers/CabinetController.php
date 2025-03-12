<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cabinet\StoreCabinetRequest;
use App\Http\Requests\Cabinet\UpdateCabinetRequest;
use App\Http\Resources\Cabinet\IndexResource;
use App\Http\Resources\Cabinet\ShowResource;
use App\Models\Cabinet;
use App\Models\Building;
use App\Services\CabinetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CabinetController extends Controller
{
    protected CabinetService $service;

    public function __construct(CabinetService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Cabinet::class);
        $cabinets = $this->service->index();
        return IndexResource::collection($cabinets);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreCabinetRequest $request): ShowResource
    {
        Gate::authorize('create', Cabinet::class);
        $data = $request->validated();
        $cabinet = $this->service->store($data);
        return new ShowResource($cabinet);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ShowResource
    {
        $cabinet = $this->service->show($id);
        Gate::authorize('view', $cabinet);
        return new ShowResource($cabinet);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateCabinetRequest $request, Cabinet $cabinet): ShowResource
    {
        Gate::authorize('update', $cabinet);
        $data = $request->validated();
        $cabinetUpdated = $this->service->update($cabinet, $data);
        return new ShowResource($cabinetUpdated);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(Cabinet $cabinet): Response|JsonResponse
    {
        Gate::authorize('delete', $cabinet);
        if ($this->service->destroy($cabinet)) {
            return response()->noContent();
        }
        return response()->json(['message' => 'Ошибка при удалении кабинета'], 500);
    }

    public function getCabinetsByFloor(Building $building, int $floor): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Cabinet::class);
        $cabinets = $this->service->getCabinetsByFloor($building, $floor);
        return IndexResource::collection($cabinets);
    }
}
