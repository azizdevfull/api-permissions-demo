<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

    Route::get('posts', [PostController::class, 'index'])->middleware('can:post view');
    Route::get('posts/{post}', [PostController::class, 'show'])->middleware('can:post view');
    Route::post('posts', [PostController::class, 'store'])->middleware('can:post create');
    Route::put('posts/{post}', [PostController::class, 'update'])->middleware('can:post update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->middleware('can:post delete');

});
