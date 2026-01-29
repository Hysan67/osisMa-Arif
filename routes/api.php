<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\BidangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AnggotaController;
use App\Http\Controllers\Api\Admin\AspirasiController;
use App\Http\Controllers\Api\PublicAspirasiController;

Route::get('/announcements/active', [ArtikelController::class, 'activeAnnouncements']);

Route::middleware('auth:sanctum')->group(function () {
   Route::post('/artikels', [ArtikelController::class, 'store']);
   Route::put('/artikels/{artikel}', [ArtikelController::class, 'update']);
   Route::delete('/artikels/{artikel}', [ArtikelController::class, 'destroy']);
   Route::put('/artikels-restore/{id}', [ArtikelController::class, 'restore']);
   Route::post('/announcements/cleanup', [ArtikelController::class, 'cleanupExpiredAnnouncements']);
   Route::delete('/artikels-force/{id}', [ArtikelController::class, 'forceDelete']);
});

Route::prefix('bidang')->group(function () {
    Route::get('/', [BidangController::class, 'index']);
    Route::get('/all', [BidangController::class, 'indexWithTrashed']); 
    Route::get('/trashed', [BidangController::class, 'trashed']); 
    Route::post('/', [BidangController::class, 'store']);
    Route::get('/{id}', [BidangController::class, 'show']);
    Route::put('/{id}', [BidangController::class, 'update']);
    Route::delete('/{id}', [BidangController::class, 'destroy']);
    Route::delete('/force/{id}', [BidangController::class, 'forceDestroy']);
    Route::post('/restore/{id}', [BidangController::class, 'restore']); // 
    Route::get('/with-anggota-count', [BidangController::class, 'withAnggotaCount']);
});

Route::prefix('v1')->group(function () {
   Route::get('/bidang', [BidangController::class, 'index']);
   Route::get('/bidang/{id}', [BidangController::class, 'show']);
   Route::get('/anggota', [AnggotaController::class, 'index']);
   Route::get('/anggota/{id}', [AnggotaController::class, 'show']);
});

Route::prefix('anggota')->group(function () {
   Route::get('/', [AnggotaController::class, 'index']);
   Route::post('/', [AnggotaController::class, 'store']);
   Route::get('/search', [AnggotaController::class, 'search']);
   Route::get('/{id}', [AnggotaController::class, 'show']);
   Route::put('/{id}', [AnggotaController::class, 'update']);
   Route::delete('/{id}', [AnggotaController::class, 'destroy']);
   // Opsional: route untuk toggle status
   Route::put('/{id}/toggle-status', [AnggotaController::class, 'toggleStatus']);
   Route::put('/{id}/status', [AnggotaController::class, 'toggleStatus']); // Alternatif
});

Route::prefix('admin')->group(function () {
   Route::get('/aspirasi', [AspirasiController::class, 'index']);
   Route::post('/aspirasi/bulk-update', [AspirasiController::class, 'bulkUpdate']);
   Route::post('/aspirasi/{id}/update-status', [AspirasiController::class, 'updateStatus']);
   Route::delete('/aspirasi/{id}', [AspirasiController::class, 'destroy']);
   Route::get('/aspirasi/export', [AspirasiController::class, 'exportCsv'])->middleware('auth:sanctum'); // Tambahkan ini
});

Route::post('/aspirasi', [PublicAspirasiController::class, 'store']);

Route::get('/artikels', [ArtikelController::class, 'index']);
Route::get('/artikels/{artikel}', [ArtikelController::class, 'show']);
Route::get('/artikels-trash', [ArtikelController::class, 'trash']); 

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('pendaftaran-osis')->group(function () {
   Route::post('/', [\App\Http\Controllers\Api\PendaftaranOsisController::class, 'store']); // Public
   Route::get('/', [\App\Http\Controllers\Api\PendaftaranOsisController::class, 'index'])->middleware('auth:sanctum');
   Route::get('/stats', [\App\Http\Controllers\Api\PendaftaranOsisController::class, 'getStats'])->middleware('auth:sanctum');
   Route::put('/{id}/status', [\App\Http\Controllers\Api\PendaftaranOsisController::class, 'updateStatus'])->middleware('auth:sanctum');
   Route::delete('/{id}', [\App\Http\Controllers\Api\PendaftaranOsisController::class, 'destroy'])->middleware('auth:sanctum');
   Route::get('/export', [\App\Http\Controllers\Api\PendaftaranOsisController::class, 'exportCsv'])->middleware('auth:sanctum');
   Route::get('/settings', [\App\Http\Controllers\Api\PendaftaranOsisController::class, 'getSettings']);
   Route::post('/settings/toggle', [\App\Http\Controllers\Api\PendaftaranOsisController::class, 'toggleRegistration'])->middleware('auth:sanctum');
});