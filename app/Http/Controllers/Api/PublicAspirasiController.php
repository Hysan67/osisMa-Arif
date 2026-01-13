<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicAspirasiController extends Controller
{
    private $csvFile = 'aspirasi.csv';

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'kelas' => 'nullable|string|max:50',
            'email' => 'required|email|max:100',
            'judul' => 'required|string|max:200',
            'pesan' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $aspirasi = Aspirasi::create([
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'email' => $request->email,
                'judul' => $request->judul,
                'pesan' => $request->pesan,
                'status' => 'menunggu',
            ]);

            // Simpan ke CSV (tanpa mengganggu proses utama)
            $this->saveToCsv($aspirasi);

            return response()->json([
                'success' => true,
                'message' => 'Aspirasi berhasil dikirim! Akan ditinjau oleh admin.',
                'data' => [
                    'id' => $aspirasi->id,
                    'nama' => $aspirasi->nama,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim aspirasi. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Save to CSV without throwing exception
     */
    private function saveToCsv($aspirasi)
    {
        try {
            $csvPath = storage_path('app/' . $this->csvFile);
            $file = fopen($csvPath, 'a');

            // Jika file baru, tulis header
            if (filesize($csvPath) === 0) {
                fputcsv($file, ['id', 'nama', 'kelas', 'email', 'judul', 'pesan', 'status', 'admin_id', 'created_at', 'updated_at']);
            }

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

            fclose($file);
        } catch (\Exception $e) {
            // Jangan throw exception, hanya log error
            \Log::warning('CSV save failed: ' . $e->getMessage());
        }
    }
}