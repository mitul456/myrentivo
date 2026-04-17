<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\TenantController;
use App\Http\Controllers\API\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // 👑 Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return response()->json([
                'message' => 'Welcome Admin'
            ]);
        });
    });

    // 🏠 Landlord only routes
    Route::middleware('role:landlord')->group(function () {
        Route::get('/landlord/dashboard', function () {
            return response()->json([
                'message' => 'Welcome Landlord'
            ]);
        });

        Route::apiResource('properties', PropertyController::class);
        Route::apiResource('units', UnitController::class);
        Route::apiResource('tenants', TenantController::class);
    });

    // 👤 Shared access
    Route::middleware('role:admin,landlord')->get('/profile', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });
});
