<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\AuthController;

route::middleware('auth:sanctum')->group(function () {
    // Route yang memerlukan autentikasi
    Route::apiResource('artikels', ArtikelController::class); 
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');