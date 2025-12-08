<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\AuthController;

// Testing tanpa middleware dulu
Route::middleware('auth:sanctum')->group(function () {
   Route::post('/artikels', [ArtikelController::class, 'store']);
   Route::put('/artikels/{artikel}', [ArtikelController::class, 'update']);
   Route::delete('/artikels/{artikel}', [ArtikelController::class, 'destroy']);
   Route::put('/artikels-restore/{id}', [ArtikelController::class, 'restore']);
   Route::delete('/artikels-force/{id}', [ArtikelController::class, 'forceDelete']);
});

Route::get('/artikels', [ArtikelController::class, 'index']);
Route::get('/artikels/{artikel}', [ArtikelController::class, 'show']);
Route::get('/artikels-trash', [ArtikelController::class, 'trash']); 

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');