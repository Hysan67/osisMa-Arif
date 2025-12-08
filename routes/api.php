<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\BidangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AnggotaController;

Route::middleware('auth:sanctum')->group(function () {
   Route::post('/artikels', [ArtikelController::class, 'store']);
   Route::put('/artikels/{artikel}', [ArtikelController::class, 'update']);
   Route::delete('/artikels/{artikel}', [ArtikelController::class, 'destroy']);
   Route::put('/artikels-restore/{id}', [ArtikelController::class, 'restore']);
   Route::delete('/artikels-force/{id}', [ArtikelController::class, 'forceDelete']);
});

Route::prefix('bidang')->group(function () {
   Route::get('/', [BidangController::class, 'index']);
   Route::post('/', [BidangController::class, 'store']);
   Route::get('/search', [BidangController::class, 'search']);
   Route::get('/with-count', [BidangController::class, 'withAnggotaCount']);
   Route::get('/{id}', [BidangController::class, 'show']);
   Route::put('/{id}', [BidangController::class, 'update']);
   Route::delete('/{id}', [BidangController::class, 'destroy']);
});

Route::prefix('anggota')->group(function () {
   Route::get('/', [AnggotaController::class, 'index']);
   Route::post('/', [AnggotaController::class, 'store']);
   Route::get('/search', [AnggotaController::class, 'search']);
   Route::get('/{id}', [AnggotaController::class, 'show']);
   Route::post('/{id}', [AnggotaController::class, 'update']);
   Route::delete('/{id}', [AnggotaController::class, 'destroy']);
});

Route::get('/artikels', [ArtikelController::class, 'index']);
Route::get('/artikels/{artikel}', [ArtikelController::class, 'show']);
Route::get('/artikels-trash', [ArtikelController::class, 'trash']); 

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');