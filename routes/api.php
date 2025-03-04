<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CabinetTypeController;
use App\Http\Controllers\EquipmentBrandController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentModelController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\FurnitureTypeController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('buildings', BuildingController::class);
Route::apiResource('cabinets', CabinetController::class);
Route::apiResource('cabinet-types', CabinetTypeController::class);
Route::apiResource('equipment-brands', EquipmentBrandController::class);
Route::apiResource('equipment-models', EquipmentModelController::class);
Route::apiResource('equipment-types', EquipmentTypeController::class);
Route::apiResource('equipments', EquipmentController::class);
Route::apiResource('furniture-types', FurnitureTypeController::class);
Route::apiResource('furnitures', FurnitureController::class);
Route::apiResource('roles', RoleController::class);

