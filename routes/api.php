<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CabinetTypeController;
use App\Http\Controllers\EquipmentBrandController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentModelController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\FurnitureTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('buildings', BuildingController::class);
    Route::apiResource('cabinets', CabinetController::class);
    Route::get('cabinets/buildings/{building}/floor/{floor}', [CabinetController::class, 'getCabinetsByFloor']);
    Route::apiResource('cabinet-types', CabinetTypeController::class);
    Route::apiResource('equipment-brands', EquipmentBrandController::class);
    Route::apiResource('equipment-models', EquipmentModelController::class);
    Route::apiResource('equipment-types', EquipmentTypeController::class);
    Route::apiResource('equipments', EquipmentController::class);
    Route::apiResource('furniture-types', FurnitureTypeController::class);
    Route::apiResource('furnitures', FurnitureController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('users', UserController::class);
});


