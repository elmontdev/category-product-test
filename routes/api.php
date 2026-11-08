<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//category crud
//method 1
// Route::get("/categories", [CategoryController::class, "index"]);
// Route::get("/categories/{id}", [CategoryController::class, "show"]);
// Route::post("/categories", [CategoryController::class, "store"]);
// Route::put("/categories/{id}", [CategoryController::class, "update"]);
// Route::delete("/categories/{id}", [CategoryController::class, "destroy"]);

//method 2
Route::apiResource("/categories", CategoryController::class);

//product crud
Route::apiResource("/products", ProductController::class);
