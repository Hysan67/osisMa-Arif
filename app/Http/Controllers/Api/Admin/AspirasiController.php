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
<<<<<<< Updated upstream

=======
    private $jsonBackupFile = 'backup_aspirasi.json';
    
>>>>>>> Stashed changes
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
        
        // Update juga di CSV
        $this->updateAspirasiInCsv($aspirasi);
        
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
            
            // Hapus juga dari CSV
            $this->deleteAspirasiFromCsv($id);
            
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
            
        // Update juga di CSV
        foreach ($request->aspirasi_ids as $id) {
            $aspirasi = Aspirasi::find($id);
            if ($aspirasi) {
                $this->updateAspirasiInCsv($aspirasi);
            }
        }
            
        return response()->json([
            'success' => true,
            'message' => "{$updated} aspirasi berhasil diperbarui",
            'updated_count' => $updated
        ]);
    }
<<<<<<< Updated upstream

    /**
     * Ekspor semua aspirasi ke CSV (manual download)
=======
    
    /**
     * Export to CSV
>>>>>>> Stashed changes
     */
    public function exportCsv()
    {
        try {
<<<<<<< Updated upstream
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
=======
            // Ambil data dari database
            $query = Aspirasi::query();
            
            // Filter berdasarkan status
            if (request()->has('status')) {
                $query->where('status', request()->status);
            }
            
            // Filter berdasarkan tanggal
            if (request()->has('start_date')) {
                $query->whereDate('created_at', '>=', request()->start_date);
            }
            
            if (request()->has('end_date')) {
                $query->whereDate('created_at', '<=', request()->end_date);
            }
            
            // Search
            if (request()->has('search')) {
                $search = request()->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('judul', 'like', "%{$search}%")
                      ->orWhere('pesan', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            // Sort
            $sortField = request()->get('sort_by', 'created_at');
            $sortDirection = request()->get('sort_dir', 'desc');
            $query->orderBy($sortField, $sortDirection);
            
            $aspirasi = $query->get();
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="aspirasi_export_' . date('Y-m-d_H-i-s') . '.csv"',
            ];
            
            $callback = function() use ($aspirasi) {
                $file = fopen('php://output', 'w');
                
                // Headers - sesuaikan dengan kolom aspirasi
                $headers = [
                    'id', 'nama', 'email', 'judul', 'pesan', 
                    'status', 'admin_id', 'created_at', 'updated_at'
                ];
                
                fputcsv($file, $headers);
                
                foreach ($aspirasi as $item) {
                    fputcsv($file, [
                        $item->id, 
                        $item->nama, 
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
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor  ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Import from CSV
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);
        
        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            $data = array();
            
            if (($handle = fopen($path, "r")) !== FALSE) {
                // Skip header row
                fgetcsv($handle);
                
                while (($row = fgetcsv($handle)) !== FALSE) {
                    if (strtolower($row[0]) === 'total') {
                        continue;
                    }
                    
                    $data[] = [
                        'id' => $row[0],
                        'nama' => $row[1],
                        'email' => $row[2],
                        'judul' => $row[3],
                        'pesan' => $row[4],
                        'status' => $row[5],
                        'admin_id' => $row[6],
                        'created_at' => $row[7],
                        'updated_at' => $row[8]
                    ];
                }
                fclose($handle);
            }
            
            // Simpan ke database
            foreach ($data as $item) {
                Aspirasi::updateOrCreate(
                    ['id' => $item['id']], // Cari berdasarkan ID
                    $item // Update atau buat baru
                );
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diimpor dari CSV',
                'count' => count($data)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimpor  ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Sync all database records to CSV file
     */
    public function syncDatabaseToCsv()
    {
        try {
            $aspirasi = Aspirasi::all();
            $csvPath = storage_path('app/' . $this->csvFile);
            $jsonPath = storage_path('app/' . $this->jsonBackupFile);
            
            // Save to CSV
            if ($aspirasi->count() > 0) {
                $file = fopen($csvPath, 'w');
                $headers = [
                    'id', 'nama', 'email', 'judul', 'pesan', 
                    'status', 'admin_id', 'created_at', 'updated_at'
                ];
                fputcsv($file, $headers);
                
                foreach ($aspirasi as $item) {
                    fputcsv($file, [
                        $item->id, 
                        $item->nama, 
                        $item->email, 
                        $item->judul, 
                        $item->pesan, 
                        $item->status, 
                        $item->admin_id, 
                        $item->created_at, 
                        $item->updated_at
                    ]);
                }
                
                // Add total row
                $totalRow = array_fill(0, count($headers), '');
                $totalRow[0] = 'Total';
                $totalRow[count($totalRow) - 1] = $aspirasi->count();
                fputcsv($file, $totalRow);
                
                fclose($file);
            } else {
                $headers = 'id,nama,email,judul,pesan,status,admin_id,created_at,updated_at';
                file_put_contents($csvPath, $headers . PHP_EOL . 'Total,,,,,,,,0');
            }
            
            // Save to JSON backup
            $aspirasiArray = $aspirasi->map(function($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'email' => $item->email,
                    'judul' => $item->judul,
                    'pesan' => $item->pesan,
                    'status' => $item->status,
                    'admin_id' => $item->admin_id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                ];
            })->toArray();
            
            file_put_contents($jsonPath, json_encode($aspirasiArray, JSON_PRETTY_PRINT));
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disinkronisasi ke CSV'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyinkronisasi data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update aspirasi in CSV file
     */
    private function updateAspirasiInCsv($aspirasi)
    {
        $csvPath = storage_path('app/' . $this->csvFile);
        if (!file_exists($csvPath)) {
            // Jika file CSV belum ada, buat dari database
            $this->syncDatabaseToCsv();
            return;
        }
        
        $tempFile = tmpfile();
        $file = fopen($csvPath, 'r');
        $headers = fgetcsv($file);
        fputcsv($tempFile, $headers);
        
        $updated = false;
        while (($row = fgetcsv($file)) !== false) {
            if ($row[0] === $aspirasi->id) {
                // Update row
                fputcsv($tempFile, [
                    $aspirasi->id,
                    $aspirasi->nama,
                    $aspirasi->email,
                    $aspirasi->judul,
                    $aspirasi->pesan,
                    $aspirasi->status,
                    $aspirasi->admin_id,
                    $aspirasi->created_at,
                    $aspirasi->updated_at
                ]);
                $updated = true;
            } else {
                fputcsv($tempFile, $row);
            }
        }
        
        if (!$updated) {
            // Jika ID tidak ditemukan, tambahkan sebagai baris baru
            fputcsv($tempFile, [
                $aspirasi->id,
                $aspirasi->nama,
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
        file_put_contents($csvPath, stream_get_contents($tempFile, -1, 0));
        fclose($tempFile);
        
        // Update JSON backup
        $this->updateJsonBackup($aspirasi);
    }
    
    /**
     * Delete aspirasi from CSV file
     */
    private function deleteAspirasiFromCsv($id)
    {
        $csvPath = storage_path('app/' . $this->csvFile);
        if (!file_exists($csvPath)) {
            return;
        }
        
        $tempFile = tmpfile();
        $file = fopen($csvPath, 'r');
        $headers = fgetcsv($file);
        fputcsv($tempFile, $headers);
        
        while (($row = fgetcsv($file)) !== false) {
            if ($row[0] !== $id) {
                fputcsv($tempFile, $row);
            }
        }
        
        fclose($file);
        file_put_contents($csvPath, stream_get_contents($tempFile, -1, 0));
        fclose($tempFile);
        
        // Update JSON backup
        $this->deleteFromJsonBackup($id);
    }
    
    /**
     * Update JSON backup
     */
    private function updateJsonBackup($aspirasi)
    {
        $jsonPath = storage_path('app/' . $this->jsonBackupFile);
        $backupData = [];
        
        if (file_exists($jsonPath)) {
            $backupData = json_decode(file_get_contents($jsonPath), true) ?? [];
        }
        
        $aspirasiArray = [
            'id' => $aspirasi->id,
            'nama' => $aspirasi->nama,
            'email' => $aspirasi->email,
            'judul' => $aspirasi->judul,
            'pesan' => $aspirasi->pesan,
            'status' => $aspirasi->status,
            'admin_id' => $aspirasi->admin_id,
            'created_at' => $aspirasi->created_at,
            'updated_at' => $aspirasi->updated_at
        ];
        
        // Check if already exists
        $exists = false;
        foreach ($backupData as &$item) {
            if ($item['id'] === $aspirasi->id) {
                $item = $aspirasiArray;
                $exists = true;
                break;
            }
        }
        
        if (!$exists) {
            $backupData[] = $aspirasiArray;
        }
        
        file_put_contents($jsonPath, json_encode($backupData, JSON_PRETTY_PRINT));
    }
    
    /**
     * Delete from JSON backup
     */
    private function deleteFromJsonBackup($id)
    {
        $jsonPath = storage_path('app/' . $this->jsonBackupFile);
        if (!file_exists($jsonPath)) {
            return;
        }
        
        $backupData = json_decode(file_get_contents($jsonPath), true) ?? [];
        
        $backupData = array_filter($backupData, function($item) use ($id) {
            return $item['id'] !== $id;
        });
        
        file_put_contents($jsonPath, json_encode(array_values($backupData), JSON_PRETTY_PRINT));
>>>>>>> Stashed changes
    }
}