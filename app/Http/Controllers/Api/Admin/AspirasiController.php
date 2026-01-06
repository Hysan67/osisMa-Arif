<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AspirasiResource;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AspirasiController extends Controller
{
    private $csvFile = 'aspirasi.csv';

    public function index(Request $request)
    {
        $query = Aspirasi::query();
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_dir', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $perPage = $request->get('per_page', 20);
        $aspirasis = $query->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => AspirasiResource::collection($aspirasis),
            'meta' => [
                'total' => $aspirasis->total(),
                'per_page' => $aspirasis->perPage(),
                'current_page' => $aspirasis->currentPage(),
                'last_page' => $aspirasis->lastPage(),
            ],
            'stats' => [
                'total' => Aspirasi::count(),
                'menunggu' => Aspirasi::where('status', 'menunggu')->count(),
                'dibalas' => Aspirasi::where('status', 'dibalas')->count(),
                'ditolak' => Aspirasi::where('status', 'ditolak')->count(),
            ]
        ]);
    }
    
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['menunggu', 'dibalas', 'ditolak'])],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $aspirasi = Aspirasi::find($id);
        
        if (!$aspirasi) {
            return response()->json([
                'success' => false,
                'message' => 'Aspirasi tidak ditemukan'
            ], 404);
        }
        
        $aspirasi->status = $request->status;
        $aspirasi->admin_id = Auth::id();
        $aspirasi->save();

        // ✅ Simpan ke CSV
        $this->saveAspirasiToCsv();
        
        return response()->json([
            'success' => true,
            'message' => 'Status aspirasi berhasil diperbarui',
            'data' => new AspirasiResource($aspirasi)
        ]);
    }
    
    public function destroy($id)
    {
        try {
            $aspirasi = Aspirasi::find($id);
            
            if (!$aspirasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aspirasi tidak ditemukan'
                ], 404);
            }
            
            $deleted = $aspirasi->delete();
            
            if ($deleted) {
                // ✅ Simpan ke CSV setelah hapus
                $this->saveAspirasiToCsv();
                return response()->json([
                    'success' => true,
                    'message' => 'Aspirasi berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus aspirasi'
                ], 500);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus aspirasi: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aspirasi_ids' => 'required|array',
            'aspirasi_ids.*' => 'exists:aspirasis,id',
            'status' => ['required', Rule::in(['menunggu', 'dibalas', 'ditolak'])],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $updated = Aspirasi::whereIn('id', $request->aspirasi_ids)
            ->update([
                'status' => $request->status,
                'admin_id' => Auth::id(),
                'updated_at' => now(),
            ]);

        // ✅ Simpan ke CSV
        $this->saveAspirasiToCsv();
            
        return response()->json([
            'success' => true,
            'message' => "{$updated} aspirasi berhasil diperbarui",
            'updated_count' => $updated
        ]);
    }

    /**
     * Ekspor semua aspirasi ke CSV (manual download)
     */
    public function exportCsv()
    {
        try {
            $aspirasis = Aspirasi::all();
            if ($aspirasis->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada data untuk diekspor'], 404);
            }

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="aspirasi_' . now()->format('Y-m-d_H-i-s') . '.csv"',
            ];

            $callback = function () use ($aspirasis) {
                $file = fopen('php://output', 'w');

                fputcsv($file, [
                    'ID',
                    'Nama',
                    'Email',
                    'Kelas',
                    'Judul',
                    'Pesan',
                    'Status',
                    'Admin ID',
                    'Dibuat',
                    'Diperbarui'
                ]);

                foreach ($aspirasis as $aspirasi) {
                    fputcsv($file, [
                        $aspirasi->id,
                        $aspirasi->nama,
                        $aspirasi->email,
                        $aspirasi->kelas ?? '-',
                        $aspirasi->judul,
                        substr(strip_tags($aspirasi->pesan), 0, 200) . '...',
                        $aspirasi->status,
                        $aspirasi->admin_id ?? '-',
                        $aspirasi->created_at->format('Y-m-d H:i:s'),
                        $aspirasi->updated_at->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor CSV: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Simpan semua data aspirasi ke file CSV (full replace)
     */
    private function saveAspirasiToCsv()
    {
        try {
            $csvPath = storage_path('app/' . $this->csvFile);
            
            // Pastikan folder ada
            if (!is_dir(dirname($csvPath))) {
                mkdir(dirname($csvPath), 0755, true);
            }

            $allAspirasi = Aspirasi::all();
            $file = fopen($csvPath, 'w');

          
            // Header
            fputcsv($file, [
                'id', 'nama', 'email', 'kelas', 'judul', 'pesan', 'status', 'admin_id', 'created_at', 'updated_at'
            ]);

            // Data
            foreach ($allAspirasi as $aspirasi) {
                fputcsv($file, [
                    $aspirasi->id,
                    $aspirasi->nama,
                    $aspirasi->email,
                    $aspirasi->kelas ?? '',
                    $aspirasi->judul,
                    $aspirasi->pesan,
                    $aspirasi->status,
                    $aspirasi->admin_id ?? '',
                    $aspirasi->created_at->toDateTimeString(),
                    $aspirasi->updated_at->toDateTimeString(),
                ]);
            }

            fclose($file);
        } catch (\Exception $e) {
        }
    }
}