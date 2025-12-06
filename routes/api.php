<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ArtikelController;

// Grup untuk route yang perlu CORS dan otentikasi Sanctum
Route::middleware([\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class])
    ->group(function () {

        // Route login/logout (otentikasi Sanctum)
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

        // Grup untuk CRUD Artikel (dilindungi oleh Sanctum)
        Route::middleware('auth:sanctum')->group(function () {
            Route::apiResource('artikels', ArtikelController::class);
            Route::patch('/artikels/{id}/restore', [ArtikelController::class, 'restore']);
        });
    });