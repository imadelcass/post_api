<?php

use Illuminate\Http\Request;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


Route::post("/login", [PostController::class, 'login']);


Route::get("/posts", [PostController::class, 'index']);
Route::get("/categories", [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/post/create", [PostController::class, 'create']);
    Route::post("/post/update", [PostController::class, 'update']);
    Route::delete("/post/destroy", [PostController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post("/category/create", [CategoryController::class, 'create']);
    Route::post("/category/update", [CategoryController::class, 'update']);
    Route::delete("/category/destroy", [CategoryController::class, 'destroy']);
});


