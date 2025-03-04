<?php

namespace App\Http\Controllers;

use App\Http\Requests\Furniture\StoreFurnitureRequest;
use App\Http\Requests\Furniture\UpdateFurnitureRequest;
use App\Http\Resources\Furniture\IndexResource;
use App\Http\Resources\Furniture\ShowResource;
use App\Models\Furniture;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FurnitureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $furniture = Furniture::get();
        return IndexResource::collection($furniture);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFurnitureRequest $request): ShowResource
    {
        $data = $request->validated();
        $furniture = Furniture::create($data);
        return new ShowResource($furniture);
    }

    /**
     * Display the specified resource.
     */
    public function show(Furniture $furniture): ShowResource
    {
        return new ShowResource($furniture);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFurnitureRequest $request, Furniture $furniture): ShowResource
    {
        $data = $request->validated();
        $furniture->update($data);
        return new ShowResource($furniture);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Furniture $furniture): Response
    {
        $furniture->delete();
        return response()->noContent();
    }
}
