<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCabinetRequest;
use App\Http\Requests\UpdateCabinetRequest;
use App\Models\Cabinet;

class CabinetController extends Controller
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
    public function store(StoreCabinetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabinet $cabinet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCabinetRequest $request, Cabinet $cabinet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabinet $cabinet)
    {
        //
    }
}
