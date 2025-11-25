<?php

use Illuminate\Support\Facades\Route;

// Semua routes diarahkan ke Vue app
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');