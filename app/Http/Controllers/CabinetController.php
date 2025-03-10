<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cabinet\StoreCabinetRequest;
use App\Http\Requests\Cabinet\UpdateCabinetRequest;
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
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCabinetRequest $request): ShowResource
    {
        Gate::authorize('create', Cabinet::class);
        $data = $request->validated();
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabinet $cabinet): ShowResource
    {
        Gate::authorize('view', $cabinet);
        return $this->service->show($cabinet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCabinetRequest $request, Cabinet $cabinet): ShowResource
    {
        Gate::authorize('update', $cabinet);
        $data = $request->validated();
        return $this->service->update($cabinet, $data);
    }

    /**
     * Remove the specified resource from storage.
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
        return $this->service->getCabinetsByFloor($building, $floor);
    }
}
