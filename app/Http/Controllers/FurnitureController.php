<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFurnitureRequest;
use App\Http\Requests\UpdateFurnitureRequest;
use App\Models\Furniture;

class FurnitureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFurnitureRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Furniture $furniture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFurnitureRequest $request, Furniture $furniture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Furniture $furniture)
    {
        //
    }
}
