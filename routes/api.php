<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, 'login']);
Route::apiResource('post', PostController::class)->only(['index', 'show']);
Route::apiResource('category', CategoryController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/')->group(function () {
        Route::post("logout", [AuthController::class, 'logout']);
        Route::get("auth", [AuthController::class, 'auth']);
    });
    Route::apiResource('post', PostController::class)->except(['index', 'show']);
    Route::apiResource('category', CategoryController::class)->except(['index', 'show']);
});
