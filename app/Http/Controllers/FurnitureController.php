<?php

namespace App\Http\Controllers;

use App\Http\Requests\Furniture\StoreFurnitureRequest;
use App\Http\Requests\Furniture\UpdateFurnitureRequest;
use App\Http\Resources\Furniture\ShowResource;
use App\Models\Furniture;
use App\Services\FurnitureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class FurnitureController extends Controller
{
    protected FurnitureService $service;

    public function __construct(FurnitureService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Furniture::class);
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreFurnitureRequest $request): ShowResource
    {
        Gate::authorize('create', Furniture::class);
        $data = $request->validated();
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Furniture $furniture): ShowResource
    {
        Gate::authorize('view', $furniture);
        return $this->service->show($furniture);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateFurnitureRequest $request, Furniture $furniture): ShowResource
    {
        Gate::authorize('update', $furniture);
        $data = $request->validated();
        return $this->service->update($furniture, $data);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(Furniture $furniture): Response|JsonResponse
    {
        Gate::authorize('delete', $furniture);
        if ($this->service->destroy($furniture)) {
            return response()->noContent();
        } else {
            return response()->json(['message' => 'Ошибка при удаление мебели']);
        }
    }
}
