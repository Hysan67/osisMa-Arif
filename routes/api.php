<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\BidangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AnggotaController;
use App\Http\Controllers\Api\Admin\AspirasiController;
use App\Http\Controllers\Api\PublicAspirasiController;
use App\Http\Controllers\PendaftaranOSISController;

Route::get('/pendaftaran-osis', [PendaftaranOSISController::class, 'index']);

Route::prefix('api')->group(function () {
   Route::post('/pendaftaran-osis', [PendaftaranOSISController::class, 'store']);
   Route::get('/pendaftaran-osis', [PendaftaranOSISController::class, 'getAllPendaftaran']);
   Route::get('/pendaftaran-osis/export', [PendaftaranOSISController::class, 'exportCSV']);
});

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

Route::prefix('v1')->group(function () {
   // API untuk bidang
   Route::get('/bidang', [BidangController::class, 'index']);
   Route::get('/bidang/{id}', [BidangController::class, 'show']);
   Route::get('/bidang/{id}/anggota', [BidangController::class, 'anggota']);
   
   // API untuk anggota
   Route::get('/anggota', [App\Http\Controllers\Api\AnggotaController::class, 'index']);
   Route::get('/anggota/{id}', [App\Http\Controllers\Api\AnggotaController::class, 'show']);
});

Route::prefix('anggota')->group(function () {
   Route::get('/', [AnggotaController::class, 'index']);
   Route::post('/', [AnggotaController::class, 'store']);
   Route::get('/search', [AnggotaController::class, 'search']);
   Route::get('/{id}', [AnggotaController::class, 'show']);
   Route::put('/{id}', [AnggotaController::class, 'update']);
   Route::delete('/{id}', [AnggotaController::class, 'destroy']);
});

Route::prefix('admin')->group(function () {
   Route::get('/aspirasi', [AspirasiController::class, 'index']);
   Route::post('/aspirasi/bulk-update', [AspirasiController::class, 'bulkUpdate']);
   Route::post('/aspirasi/{id}/update-status', [AspirasiController::class, 'updateStatus']);
   Route::delete('/aspirasi/{id}', [AspirasiController::class, 'destroy']);
});

Route::post('/aspirasi', [PublicAspirasiController::class, 'store']);

Route::get('/artikels', [ArtikelController::class, 'index']);
Route::get('/artikels/{artikel}', [ArtikelController::class, 'show']);
Route::get('/artikels-trash', [ArtikelController::class, 'trash']); 

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');