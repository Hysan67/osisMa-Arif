<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AspirasiResource;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AspirasiController extends Controller
{
    private $csvFile = 'aspirasi.csv';

    public function index(Request $request)
    {
        $query = Aspirasi::query();

        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sort
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

    /**
     * Update status aspirasi (tanpa balasan)
     */
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
        $aspirasi->updated_at = now();
        $aspirasi->save();

        // Perbarui juga file CSV
        $this->updateCsvEntry($aspirasi);

        return response()->json([
            'success' => true,
            'message' => 'Status aspirasi berhasil diperbarui',
            'data' => new AspirasiResource($aspirasi)
        ]);
    }

    /**
     * Delete aspirasi.
     */
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

            // Hapus dari CSV juga
            $this->removeFromCsv($id);

            $deleted = $aspirasi->delete();

            if ($deleted) {
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

    /**
     * Bulk update status.
     */
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

        // Perbarui juga file CSV untuk semua yang diupdate
        foreach ($request->aspirasi_ids as $id) {
            $aspirasi = Aspirasi::find($id);
            if ($aspirasi) {
                $this->updateCsvEntry($aspirasi);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$updated} aspirasi berhasil diperbarui",
            'updated_count' => $updated
        ]);
    }

    /**
     * Export to CSV
     */
    public function exportCsv()
    {
        $aspirasi = Aspirasi::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="aspirasi_export_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($aspirasi) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['id', 'nama', 'kelas', 'email', 'judul', 'pesan', 'status', 'admin_id', 'created_at', 'updated_at']);

            foreach ($aspirasi as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->nama,
                    $item->kelas,
                    $item->email,
                    $item->judul,
                    $item->pesan,
                    $item->status,
                    $item->admin_id,
                    $item->created_at,
                    $item->updated_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Update specific entry in CSV file
     */
    private function updateCsvEntry($aspirasi)
    {
        try {
            $csvPath = storage_path('app/' . $this->csvFile);

            if (!file_exists($csvPath)) {
                // Jika file belum ada, buat baru dengan data ini
                $this->createNewCsv([$aspirasi]);
                return;
            }

            $rows = [];
            $file = fopen($csvPath, 'r');

            if (!$file) {
                return;
            }

            $header = fgetcsv($file); // Ambil header
            $rows[] = $header;

            // Baca semua baris
            while (($row = fgetcsv($file)) !== false) {
                if (isset($row[0]) && $row[0] == $aspirasi->id) {
                    // Ganti baris ini dengan data terbaru
                    $row = [
                        $aspirasi->id,
                        $aspirasi->nama,
                        $aspirasi->kelas,
                        $aspirasi->email,
                        $aspirasi->judul,
                        $aspirasi->pesan,
                        $aspirasi->status,
                        $aspirasi->admin_id,
                        $aspirasi->created_at,
                        $aspirasi->updated_at
                    ];
                }
                $rows[] = $row;
            }

            fclose($file);

            // Tulis ulang file dengan data terbaru
            $file = fopen($csvPath, 'w');
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);

        } catch (\Exception $e) {
        }
    }

    /**
     * Remove specific entry from CSV file
     */
    private function removeFromCsv($id)
    {
        try {
            $csvPath = storage_path('app/' . $this->csvFile);

            if (!file_exists($csvPath)) {
                return;
            }

            $rows = [];
            $file = fopen($csvPath, 'r');

            if (!$file) {
                return;
            }

            $header = fgetcsv($file); // Ambil header
            $rows[] = $header;

            // Baca semua baris, kecuali yang akan dihapus
            while (($row = fgetcsv($file)) !== false) {
                if (isset($row[0]) && $row[0] != $id) {
                    $rows[] = $row;
                }
            }

            fclose($file);

            // Tulis ulang file tanpa baris yang dihapus
            $file = fopen($csvPath, 'w');
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);

        } catch (\Exception $e) {
        }
    }

    /**
     * Create new CSV file with given entries
     */
    private function createNewCsv($aspirasiList)
    {
        try {
            $csvPath = storage_path('app/' . $this->csvFile);
            $file = fopen($csvPath, 'w');

            if (!$file) {
                return;
            }

            // Tulis header
            fputcsv($file, ['id', 'nama', 'kelas', 'email', 'judul', 'pesan', 'status', 'admin_id', 'created_at', 'updated_at']);

            // Tulis data
            foreach ($aspirasiList as $aspirasi) {
                fputcsv($file, [
                    $aspirasi->id,
                    $aspirasi->nama,
                    $aspirasi->kelas,
                    $aspirasi->email,
                    $aspirasi->judul,
                    $aspirasi->pesan,
                    $aspirasi->status,
                    $aspirasi->admin_id,
                    $aspirasi->created_at,
                    $aspirasi->updated_at
                ]);
            }

            fclose($file);

        } catch (\Exception $e) {
        }
    }
}