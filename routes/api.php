<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\AuthController;

// Testing tanpa middleware dulu
Route::get('/artikels', [ArtikelController::class, 'index']);
Route::post('/artikels', [ArtikelController::class, 'store']);
Route::get('/artikels/{artikel}', [ArtikelController::class, 'show']);
Route::put('/artikels/{artikel}', [ArtikelController::class, 'update']);
Route::delete('/artikels/{artikel}', [ArtikelController::class, 'destroy']);

// Route untuk trash/history - PASTIKAN INI ADA
Route::get('/artikels-trash', [ArtikelController::class, 'trash']); // Nama route berbeda
Route::put('/artikels-restore/{id}', [ArtikelController::class, 'restore']);
Route::delete('/artikels-force/{id}', [ArtikelController::class, 'forceDelete']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');