<?php
// app/Http/Controllers/Api/ArtikelController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::select(['id', 'judul', 'deskripsi', 'jenis_artikel', 'img', 'created_at', 'updated_at'])
                          ->latest()
                          ->get()
                          ->toArray();

        return response()->json($artikels);
    }

    public function indexAlternative()
    {
        $artikels = Artikel::latest()->get();
        
        // Konversi ke array untuk menghindari masalah serialisasi
        $data = [];
        foreach ($artikels as $artikel) {
            $data[] = [
                'id' => $artikel->id,
                'judul' => $artikel->judul,
                'deskripsi' => $artikel->deskripsi,
                'jenis_artikel' => $artikel->jenis_artikel,
                'img' => $artikel->img,
                'created_at' => $artikel->created_at,
                'updated_at' => $artikel->updated_at,
            ];
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'jenis_artikel' => 'required|in:artikel,event',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'jenis_artikel']);
        
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('artikels', 'public');
        }

        $artikel = Artikel::create($data);
        
        // Pastikan mengembalikan data yang di-refresh dari database
        return response()->json($artikel->fresh());
    }

    public function show(Artikel $artikel)
    {
        // Hanya ambil data yang diperlukan
        return response()->json([
            'id' => $artikel->id,
            'judul' => $artikel->judul,
            'deskripsi' => $artikel->deskripsi,
            'jenis_artikel' => $artikel->jenis_artikel,
            'img' => $artikel->img,
            'created_at' => $artikel->created_at,
            'updated_at' => $artikel->updated_at,
        ]);
    }

    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|required',
            'jenis_artikel' => 'sometimes|required|in:artikel,event',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'jenis_artikel']);
        
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('artikels', 'public');
        }

        $artikel->fill($data);
        $artikel->save();
        return response()->json($artikel->fresh());
    }

    public function destroy(Artikel $artikel)
    {
        $artikel->delete();
        return response()->json(['message' => 'Artikel deleted successfully']);
    }
}