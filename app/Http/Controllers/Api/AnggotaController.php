<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    public function index()
    {
        try {
            $anggotas = Anggota::with('bidang:id,nama')
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $anggotas,
                'message' => 'Data anggota berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data anggota: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'posisi' => 'required|string|max:100',
            'bidang_id' => 'nullable|exists:bidangs,id',
            'status' => 'required|in:aktif,non aktif',
            'masa_bakti' => 'required|string|max:50',
            'quote' => 'nullable|string',
            'pengalaman_prestasi' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        try {
            $data = $request->except('img');

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('anggotas', $imageName, 'public');
                $data['img'] = $imagePath;
            }

            $anggota = Anggota::create($data);

            return response()->json([
                'success' => true,
                'data' => $anggota->load('bidang:id,nama'),
                'message' => 'Anggota berhasil ditambahkan'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan anggota: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $anggota = Anggota::with('bidang')->find($id);

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $anggota,
                'message' => 'Detail anggota berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail anggota: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'posisi' => 'sometimes|required|string|max:100',
            'bidang_id' => 'nullable|exists:bidangs,id',
            'status' => 'sometimes|required|in:aktif,non aktif',
            'masa_bakti' => 'sometimes|required|string|max:50',
            'quote' => 'nullable|string',
            'pengalaman_prestasi' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        try {
            $anggota = Anggota::find($id);

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota tidak ditemukan'
                ], 404);
            }

            $data = $request->except('img');

            if ($request->hasFile('img')) {
                // Hapus gambar lama jika ada
                if ($anggota->img && Storage::disk('public')->exists($anggota->img)) {
                    Storage::disk('public')->delete($anggota->img);
                }

                // Upload gambar baru
                $image = $request->file('img');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('anggotas', $imageName, 'public');
                $data['img'] = $imagePath;
            }

            $anggota->update($data);

            return response()->json([
                'success' => true,
                'data' => $anggota->fresh()->load('bidang:id,nama'),
                'message' => 'Anggota berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui anggota: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $anggota = Anggota::find($id);

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota tidak ditemukan'
                ], 404);
            }

            // Hapus gambar jika ada
            if ($anggota->img && Storage::disk('public')->exists($anggota->img)) {
                Storage::disk('public')->delete($anggota->img);
            }

            $anggota->delete();

            return response()->json([
                'success' => true,
                'message' => 'Anggota berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus anggota: ' . $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $search = $request->query('search', '');
            $bidangId = $request->query('bidang_id');
            $status = $request->query('status');

            $query = Anggota::with('bidang:id,nama');

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('posisi', 'like', '%' . $search . '%')
                      ->orWhere('quote', 'like', '%' . $search . '%');
                });
            }

            if ($bidangId) {
                $query->where('bidang_id', $bidangId);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $anggotas = $query->latest()->get();

            return response()->json([
                'success' => true,
                'data' => $anggotas,
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