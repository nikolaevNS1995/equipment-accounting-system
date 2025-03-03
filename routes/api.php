<?php

use App\Http\Controllers\BuildingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('buildings', BuildingController::class);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
