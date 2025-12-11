<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PendaftaranOSISController extends Controller
{
    // Menampilkan form pendaftaran (jika diperlukan)
    public function index()
    {
        return view('PendaftaranOSIS'); // Pastikan file Vue ditempatkan di resources/views
    }

    // Menyimpan data pendaftaran ke CSV
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validated = $request->validate([
                'nama' => 'required|string|max:100',
                'foto' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
                'kelas' => 'required|string|max:10',
                'tempat_lahir' => 'required|string|max:50',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15',
                'asal_sekolah' => 'required|string|max:100',
                'nama_ortu_wali' => 'required|string|max:100',
                'pengalaman_prestasi' => 'nullable|string',
                'penyakit_diderita' => 'nullable|string',
                'rutinitas_menghambat' => 'nullable|string',
                'tujuan' => 'required|string',
                'harapan' => 'required|string',
                'tanggal_ortu_wali' => 'required|date',
                'status' => 'nullable|string',
                'admin_id' => 'nullable|integer'
            ]);

            // Handle upload foto
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = time() . '_' . str_replace(' ', '_', $request->nama) . '.' . $foto->getClientOriginalExtension();
                $fotoPath = $foto->storeAs('foto_pendaftaran_osis', $filename, 'public');
            }

            // Data untuk CSV
            $data = [
                'id' => uniqid('OSIS-', true),
                'nama' => $request->nama,
                'foto_path' => $fotoPath,
                'kelas' => $request->kelas,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'asal_sekolah' => $request->asal_sekolah,
                'nama_ortu_wali' => $request->nama_ortu_wali,
                'pengalaman_prestasi' => $request->pengalaman_prestasi ?? '',
                'penyakit_diderita' => $request->penyakit_diderita ?? '',
                'rutinitas_menghambat' => $request->rutinitas_menghambat ?? '',
                'tujuan' => $request->tujuan,
                'harapan' => $request->harapan,
                'tanggal_ortu_wali' => $request->tanggal_ortu_wali,
                'status' => $request->status ?? 'pending',
                'admin_id' => $request->admin_id ?? null,
                'created_at' => now()->toDateTimeString()
            ];

            // Path file CSV
            $csvFile = storage_path('app/pendaftaran_osis.csv');
            
            // Cek apakah file CSV sudah ada
            if (!file_exists($csvFile)) {
                // Buat file CSV baru dengan header
                $header = array_keys($data);
                $this->createCSVFile($csvFile, $header);
            }

            // Tambah data ke CSV
            $this->appendToCSV($csvFile, $data);

            // Backup data ke JSON (opsional)
            $this->createJSONBackup($data);

            Log::info('Pendaftaran OSIS berhasil: ' . $request->nama);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dikirim!',
                'data' => ['id' => $data['id']]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error pendaftaran OSIS: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }

    // Membuat file CSV dengan header
    private function createCSVFile($filePath, $header)
    {
        $file = fopen($filePath, 'w');
        // Tambahkan BOM untuk UTF-8
        fwrite($file, "\xEF\xBB\xBF");
        fputcsv($file, $header);
        fclose($file);
    }

    // Menambahkan data ke CSV
    private function appendToCSV($filePath, $data)
    {
        $file = fopen($filePath, 'a');
        fputcsv($file, array_values($data));
        fclose($file);
    }

    // Membuat backup JSON (opsional)
    private function createJSONBackup($data)
    {
        $jsonFile = storage_path('app/backup_pendaftaran_osis.json');
        
        $allData = [];
        if (file_exists($jsonFile)) {
            $existingData = json_decode(file_get_contents($jsonFile), true);
            if (is_array($existingData)) {
                $allData = $existingData;
            }
        }
        
        $allData[] = $data;
        file_put_contents($jsonFile, json_encode($allData, JSON_PRETTY_PRINT));
    }

    // Menampilkan semua data pendaftaran (untuk admin)
    public function getAllPendaftaran()
    {
        try {
            $csvFile = storage_path('app/pendaftaran_osis.csv');
            
            if (!file_exists($csvFile)) {
                return response()->json([
                    'success' => true,
                    'data' => []
                ]);
            }

            $data = [];
            $file = fopen($csvFile, 'r');
            
            // Lewati header
            $header = fgetcsv($file);
            
            while (($row = fgetcsv($file)) !== false) {
                $data[] = array_combine($header, $row);
            }
            
            fclose($file);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membaca data'
            ], 500);
        }
    }

    // Export data ke CSV untuk diunduh
    public function exportCSV()
    {
        $csvFile = storage_path('app/pendaftaran_osis.csv');
        
        if (!file_exists($csvFile)) {
            return response()->json([
                'success' => false,
                'message' => 'Data belum tersedia'
            ], 404);
        }

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="pendaftaran_osis_' . date('Y-m-d') . '.csv"',
        ];

        return response()->download($csvFile, 'pendaftaran_osis.csv', $headers);
    }
}