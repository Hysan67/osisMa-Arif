<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BidangController extends Controller
{
    public function index()
    {
        try {
            $bidangs = Bidang::select(['id', 'img', 'nama', 'deskripsi', 'tugas_umum', 'created_at', 'updated_at'])
                            ->latest()
                            ->get();

            return response()->json([
                'success' => true,
                'data' => $bidangs,
                'message' => 'Data bidang berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data bidang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tugas_umum' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        try {
            $data = $request->only(['nama', 'deskripsi', 'tugas_umum']);

            // Upload gambar jika ada
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('bidangs', $imageName, 'public');
                $data['img'] = $imagePath;
            }

            $bidang = Bidang::create($data);

            return response()->json([
                'success' => true,
                'data' => $bidang,
                'message' => 'Bidang berhasil dibuat'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat bidang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $bidang = Bidang::find($id);

            if (!$bidang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bidang tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $bidang,
                'message' => 'Detail bidang berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail bidang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|required|string',
            'tugas_umum' => 'sometimes|required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        try {
            $bidang = Bidang::find($id);

            if (!$bidang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bidang tidak ditemukan'
                ], 404);
            }

            $data = $request->only(['nama', 'deskripsi', 'tugas_umum']);

            // Handle upload gambar baru
            if ($request->hasFile('img')) {
                // Hapus gambar lama jika ada
                if ($bidang->img && Storage::disk('public')->exists($bidang->img)) {
                    Storage::disk('public')->delete($bidang->img);
                }

                // Upload gambar baru
                $image = $request->file('img');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('bidangs', $imageName, 'public');
                $data['img'] = $imagePath;
            }

            $bidang->update($data);

            return response()->json([
                'success' => true,
                'data' => $bidang->fresh(),
                'message' => 'Bidang berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui bidang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $bidang = Bidang::find($id);

            if (!$bidang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bidang tidak ditemukan'
                ], 404);
            }

            // Hapus gambar jika ada
            if ($bidang->img && Storage::disk('public')->exists($bidang->img)) {
                Storage::disk('public')->delete($bidang->img);
            }

            $bidang->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bidang berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus bidang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get bidang with anggota count
     */
    public function withAnggotaCount()
    {
        try {
            $bidangs = Bidang::withCount('anggotas')
                            ->latest()
                            ->get();

            return response()->json([
                'success' => true,
                'data' => $bidangs,
                'message' => 'Data bidang dengan jumlah anggota berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search bidang by nama
     */
    public function search(Request $request)
    {
        try {
            $search = $request->query('search', '');

            $bidangs = Bidang::where('nama', 'like', '%' . $search . '%')
                            ->orWhere('deskripsi', 'like', '%' . $search . '%')
                            ->orWhere('tugas_umum', 'like', '%' . $search . '%')
                            ->latest()
                            ->get();

            return response()->json([
                'success' => true,
                'data' => $bidangs,
                'message' => 'Hasil pencarian berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan pencarian: ' . $e->getMessage()
            ], 500);
        }
    }
}