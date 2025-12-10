<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicAspirasiController extends Controller
{
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
}