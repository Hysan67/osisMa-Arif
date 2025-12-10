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
        $aspirasi->save();
        
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
            
        return response()->json([
            'success' => true,
            'message' => "{$updated} aspirasi berhasil diperbarui",
            'updated_count' => $updated
        ]);
    }
}