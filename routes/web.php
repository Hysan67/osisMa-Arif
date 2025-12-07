<?php
// routes/web.php
use Illuminate\Support\Facades\Route;

// Route API harus didefinisikan SEBELUM route SPA wildcard
// (ini sudah ditangani oleh api.php)

// Route frontend SPA (harus ditempatkan di akhir)
Route::get('/', function () {
    return view('app'); // atau view('welcome')
});

// Route SPA - PASTIKAN INI ADA DI AKHIR dan tidak menangkap /api/*
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api\/).*'); // Regex untuk mengecualikan /api/*