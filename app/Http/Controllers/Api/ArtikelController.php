<?php
// app/Http/Controllers/Api/ArtikelController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::select(['id', 'judul', 'deskripsi', 'jenis_artikel', 'img', 'admin_id', 'created_at', 'updated_at'])
                          ->whereNull('deleted_at')
                          ->latest()
                          ->get()
                          ->toArray();

        return response()->json($artikels);
    }

    public function indexAlternative()
    {
        $artikels = Artikel::latest()->get();
        $data = [];
        foreach ($artikels as $artikel) {
            $data[] = [
                'id' => $artikel->id,
                'judul' => $artikel->judul,
                'deskripsi' => $artikel->deskripsi,
                'jenis_artikel' => $artikel->jenis_artikel,
                'img' => $artikel->img,
                'admin_id' => $artikel->admin_id,
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
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'jenis_artikel']);
        
        $data['admin_id'] = auth()->id();
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('artikels', 'public');
        }

        $artikel = Artikel::create($data);
        
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
            'admin_id' => $artikel->admin_id,
            'created_at' => $artikel->created_at,
            'updated_at' => $artikel->updated_at,
        ]);
    }

    public function update(Request $request, Artikel $artikel)
    {
        $rules = [];
        
        if ($request->has('judul')) {
            $rules['judul'] = 'required|string|max:255';
        }
        
        if ($request->has('deskripsi')) {
            $rules['deskripsi'] = 'required';
        }
        
        if ($request->has('jenis_artikel')) {
            $rules['jenis_artikel'] = 'required|in:artikel,event';
        }
        
        if ($request->hasFile('img')) {
            $rules['img'] = 'image|mimes:jpeg,png,jpg,gif';
        }

        if ($request->has('judul')) {
            $artikel->judul = $request->judul;
        }
        
        if ($request->has('deskripsi')) {
            $artikel->deskripsi = $request->deskripsi;
        }
        
        if ($request->has('jenis_artikel')) {
            $artikel->jenis_artikel = $request->jenis_artikel;
        }
        
        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            if ($artikel->img && Storage::disk('public')->exists($artikel->img)) {
                Storage::disk('public')->delete($artikel->img);
            }
            $artikel->img = $request->file('img')->store('artikels', 'public');
        }

        $artikel->save();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil diperbarui',
            'data' => $artikel->fresh()
        ]);
    }

    public function destroy(Artikel $artikel)
    {
        if ($artikel->img && Storage::disk('public')->exists($artikel->img)) {
            Storage::disk('public')->delete($artikel->img);
        }
        
        $artikel->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus'
        ]);
    }

    public function trash()
    {
        
        try {
            $deletedArtikels = Artikel::onlyTrashed()
                ->select(['id', 'judul', 'deskripsi', 'jenis_artikel', 'img','admin_id', 'created_at', 'deleted_at'])
                ->latest('deleted_at')
                ->get();
                
            
            return response()->json([
                'success' => true,
                'data' => $deletedArtikels
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk restore artikel
    public function restore($id)
    {
        $artikel = Artikel::withTrashed()->find($id);
        
        if (!$artikel) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }
        
        $artikel->restore();
        
        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dikembalikan',
            'data' => $artikel
        ]);
    }

    // Method untuk force delete
    public function forceDelete($id)
    {
        $artikel = Artikel::withTrashed()->find($id);
        
        if (!$artikel) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }
        
        // Hapus gambar fisik jika ada
        if ($artikel->img && Storage::disk('public')->exists($artikel->img)) {
            Storage::disk('public')->delete($artikel->img);
        }
        
        $artikel->forceDelete();
        
        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus permanen'
        ]);
    }
}