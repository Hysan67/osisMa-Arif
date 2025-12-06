<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::middleware([\Illuminate\Session\Middleware\StartSession::class])
    ->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

Route::middleware([\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, \Illuminate\Session\Middleware\StartSession::class])
    ->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.session');
    });