<?php

namespace App\Http\Controllers\Api; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth
use Illuminate\Support\Facades\Log; // Import Log

class ArtikelController extends Controller
{
    public function index()
    {
        // Ambil artikel dengan relasi admin, bisa difilter jika perlu
        $artikels = Artikel::with('admin')->paginate(10);
        return response()->json($artikels);
    }

    public function store(Request $request)
    {
        // Karena middleware 'auth:sanctum' aktif, user pasti otentikasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'jenis_artikel' => 'required|in:artikel,event',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        // Ambil ID user dari token
        $data['admin_id'] = Auth::id();

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('artikels', 'public');
        }

        $artikel = Artikel::create($data);

        return response()->json($artikel, 201);
    }

    public function show(Artikel $artikel)
    {
        return response()->json($artikel->load('admin', 'comments'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'judul' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes',
            'jenis_artikel' => 'sometimes|in:artikel,event',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('artikels', 'public');
        }

        $artikel->update($data);

        return response()->json($artikel);
    }

    public function destroy(Artikel $artikel)
    {
        $artikel->delete(); // Soft delete

        return response()->json(['message' => 'Artikel berhasil dihapus']);
    }

    public function restore($id)
    {
        $artikel = Artikel::withTrashed()->findOrFail($id);
        $artikel->restore();

        return response()->json(['message' => 'Artikel berhasil dipulihkan']);
    }
}