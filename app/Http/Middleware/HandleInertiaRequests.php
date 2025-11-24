<?php

namespace App\Http\Middleware;

use App\Models\Bidang;
use App\Models\Anggota;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'is_admin' => $request->user()->is_admin ?? false,
                ] : null,
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            // Shared data untuk semua pages (hitung jika perlu)
            'totalAnggota' => fn () => Anggota::count(),
            'totalArtikel' => fn () => Artikel::count(),
            'bidangs' => fn () => Bidang::all()->map(function ($bidang) {
                return [
                    'id' => $bidang->id,
                    'nama' => $bidang->nama,
                    'deskripsi' => $bidang->deskripsi,
                ];
            }),
        ]);
    }
}