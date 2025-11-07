<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    Route::middleware(['can:manage-roles'])->group(function () {
        Route::apiResource('roles', RolePermissionController::class);
    });
});
