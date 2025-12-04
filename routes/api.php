<?php // Pastikan ini adalah baris pertama

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan ini diimpor

Route::post('/login', [AuthController::class, 'login']); // Baris ini harus ada

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});