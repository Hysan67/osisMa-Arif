<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\AuthController;

Route::get('/artikels', [ArtikelController::class, 'index']);
Route::get('/artikels/{artikel}', [ArtikelController::class, 'show']);

Route::post('/artikels', [ArtikelController::class, 'store']);
Route::put('/artikels/{artikel}', [ArtikelController::class, 'update']);
Route::delete('/artikels/{artikel}', [ArtikelController::class, 'destroy']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');