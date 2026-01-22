<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PendaftaranOsisController extends Controller
{
    private $csvFile = 'pendaftaran_osis.csv';
    private $jsonBackupFile = 'backup_pendaftaran_osis.json';
    private $settingsFile = 'pendaftaran_settings.json';
    
    /**
     * Get registration settings (PUBLIC endpoint)
     */
    public function getSettings()
    {
        try {
            $settingsPath = storage_path('app/' . $this->settingsFile);
            
            if (file_exists($settingsPath)) {
                $content = file_get_contents($settingsPath);
                $settings = json_decode($content, true);
                
                if ($settings) {
                    return response()->json([
                        'success' => true,
                        'data' => $settings
                    ]);
                }
            }
            
            // Default settings if file doesn't exist
            $defaultSettings = [
                'is_open' => true,
                'closed_message' => 'Pendaftaran OSIS sedang ditutup.',
                'last_updated' => Carbon::now()->toDateTimeString(),
                'updated_by' => null,
                'updated_by_name' => null
            ];
            
            return response()->json([
                'success' => true,
                'data' => $defaultSettings
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle registration status (ADMIN only)
     */
    public function toggleRegistration(Request $request)
    {
        try {
            \Log::info('Toggle registration called with data:', $request->all());
            
            $request->validate([
                'is_open' => 'boolean',
                'closed_message' => 'nullable|string|max:500'
            ]);
            
            $settings = [];
            $settingsPath = storage_path('app/' . $this->settingsFile);
            
            // Load existing settings if file exists
            if (file_exists($settingsPath)) {
                $content = file_get_contents($settingsPath);
                $settings = json_decode($content, true) ?? [];
            }
            
            $user = $request->user();
            
            // Update settings
            if ($request->has('is_open')) {
                $settings['is_open'] = (bool)$request->is_open;
            } else {
                // Toggle if not provided
                $settings['is_open'] = !($settings['is_open'] ?? true);
            }
            
            $settings['closed_message'] = $request->closed_message ?? ($settings['closed_message'] ?? 'Pendaftaran OSIS sedang ditutup.');
            $settings['last_updated'] = Carbon::now()->toDateTimeString();
            $settings['updated_by'] = $user ? $user->id : null;
            $settings['updated_by_name'] = $user ? $user->name : 'System';
            
            \Log::info('New settings to save:', $settings);
            
            // Save settings
            $written = file_put_contents($settingsPath, json_encode($settings, JSON_PRETTY_PRINT));
            
            if ($written === false) {
                \Log::error('Failed to write settings file');
                throw new \Exception('Failed to write settings file. Check permissions.');
            }
            
            \Log::info('Settings saved successfully. Bytes written: ' . $written);
            
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran OSIS berhasil ' . ($settings['is_open'] ? 'dibuka' : 'ditutup'),
                'data' => $settings
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in toggleRegistration: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get all registrations
     */
    public function index(Request $request)
    {
        try {
            $registrations = $this->getAllRegistrations();
            
            // Filter by status
            if ($request->has('status') && $request->status !== 'all') {
                $registrations = array_filter($registrations, function($item) use ($request) {
                    return $item['status'] === $request->status;
                });
                $registrations = array_values($registrations);
            }
            
            // Search
            if ($request->has('search') && !empty($request->search)) {
                $search = strtolower($request->search);
                $registrations = array_filter($registrations, function($item) use ($search) {
                    return strpos(strtolower($item['nama']), $search) !== false ||
                           strpos(strtolower($item['email']), $search) !== false ||
                           strpos(strtolower($item['kelas']), $search) !== false ||
                           strpos(strtolower($item['no_hp']), $search) !== false;
                });
                $registrations = array_values($registrations);
            }
            
            // Sort
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            
            usort($registrations, function($a, $b) use ($sortBy, $sortOrder) {
                if ($sortOrder === 'asc') {
                    return $a[$sortBy] <=> $b[$sortBy];
                }
                return $b[$sortBy] <=> $a[$sortBy];
            });
            
            return response()->json([
                'success' => true,
                'data' => $registrations,
                'total' => count($registrations),
                'pending_count' => count(array_filter($registrations, fn($item) => $item['status'] === 'pending')),
                'approved_count' => count(array_filter($registrations, fn($item) => $item['status'] === 'approved')),
                'rejected_count' => count(array_filter($registrations, fn($item) => $item['status'] === 'rejected')),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch registrations: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store new registration
     */
    public function store(Request $request)
    {
        try {
            // Cek status pendaftaran
            $settings = $this->getSettingsData();
            if (!$settings['is_open']) {
                return response()->json([
                    'success' => false,
                    'message' => $settings['closed_message'] ?? 'Pendaftaran OSIS sedang ditutup.'
                ], 403);
            }
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'kelas' => 'required|string|max:10',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'asal_sekolah' => 'required|string|max:255',
                'nama_ortu_wali' => 'required|string|max:255',
                'pengalaman_prestasi' => 'nullable|string',
                'penyakit_diderita' => 'nullable|string',
                'rutinitas_menghambat' => 'nullable|string',
                'tujuan' => 'required|string',
                'harapan' => 'required|string',
                'tanggal_ortu_wali' => 'required|date',
                'status' => 'nullable|in:pending,approved,rejected',
                'admin_id' => 'nullable|integer'
            ]);
            
            // Generate unique ID
            $id = 'OSIS-' . uniqid('', true);
            
            // Handle file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $validated['nama']) . '.' . $file->getClientOriginalExtension();
                $path = 'foto_pendaftaran_osis/' . $filename;
                
                // Store file
                $file->storeAs('public/foto_pendaftaran_osis', $filename);
                $validated['foto_path'] = $path;
            }
            
            // Prepare data for CSV
            $registrationData = [
                'id' => $id,
                'nama' => $validated['nama'],
                'foto_path' => $validated['foto_path'],
                'kelas' => $validated['kelas'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'asal_sekolah' => $validated['asal_sekolah'],
                'nama_ortu_wali' => $validated['nama_ortu_wali'],
                'pengalaman_prestasi' => $validated['pengalaman_prestasi'] ?? '',
                'penyakit_diderita' => $validated['penyakit_diderita'] ?? '',
                'rutinitas_menghambat' => $validated['rutinitas_menghambat'] ?? '',
                'tujuan' => $validated['tujuan'],
                'harapan' => $validated['harapan'],
                'tanggal_ortu_wali' => $validated['tanggal_ortu_wali'],
                'status' => $validated['status'] ?? 'pending',
                'admin_id' => $validated['admin_id'] ?? null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'email' => $validated['email']
            ];
            
            // Save to CSV
            $this->saveToCsv($registrationData);
            
            // Save to JSON backup
            $this->saveToJsonBackup($registrationData);
            
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dikirim!',
                'data' => $registrationData
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update registration status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected',
                'admin_id' => 'nullable|integer',
                'notes' => 'nullable|string'
            ]);
            
            $registrations = $this->getAllRegistrations();
            $found = false;
            
            foreach ($registrations as &$registration) {
                if ($registration['id'] === $id) {
                    $registration['status'] = $request->status;
                    $registration['admin_id'] = $request->admin_id;
                    $registration['updated_at'] = Carbon::now()->toDateTimeString();
                    $registration['notes'] = $request->notes ?? '';
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran tidak ditemukan'
                ], 404);
            }
            
            // Save updated data
            $this->saveAllRegistrations($registrations);
            
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'data' => $registrations[array_search($id, array_column($registrations, 'id'))]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete registration
     */
    public function destroy($id)
    {
        try {
            $registrations = $this->getAllRegistrations();
            $newRegistrations = [];
            $deleted = null;
            
            foreach ($registrations as $registration) {
                if ($registration['id'] !== $id) {
                    $newRegistrations[] = $registration;
                } else {
                    $deleted = $registration;
                }
            }
            
            if ($deleted === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran tidak ditemukan'
                ], 404);
            }
            
            // Save without the deleted item
            $this->saveAllRegistrations($newRegistrations);
            
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dihapus',
                'data' => $deleted
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get statistics
     */
    public function getStats()
    {
        try {
            $registrations = $this->getAllRegistrations();
            
            $stats = [
                'total' => count($registrations),
                'pending' => count(array_filter($registrations, fn($item) => $item['status'] === 'pending')),
                'approved' => count(array_filter($registrations, fn($item) => $item['status'] === 'approved')),
                'rejected' => count(array_filter($registrations, fn($item) => $item['status'] === 'rejected')),
                'today' => count(array_filter($registrations, function($item) {
                    return Carbon::parse($item['created_at'])->isToday();
                })),
                'this_week' => count(array_filter($registrations, function($item) {
                    return Carbon::parse($item['created_at'])->isCurrentWeek();
                }))
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Export to CSV
     */
    public function exportCsv()
    {
        try {
            $registrations = $this->getAllRegistrations();
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="pendaftaran_osis_export_' . date('Y-m-d_H-i-s') . '.csv"',
            ];
            
            $callback = function() use ($registrations) {
                $file = fopen('php://output', 'w');
                fputcsv($file, array_keys($registrations[0] ?? []));
                
                foreach ($registrations as $registration) {
                    fputcsv($file, $registration);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Helper: Get settings data
     */
    private function getSettingsData()
    {
        $settingsPath = storage_path('app/' . $this->settingsFile);
        
        if (file_exists($settingsPath)) {
            $content = file_get_contents($settingsPath);
            $settings = json_decode($content, true);
            if ($settings) {
                return $settings;
            }
        }
        
        // Default settings
        return [
            'is_open' => true,
            'closed_message' => 'Pendaftaran OSIS sedang ditutup.',
            'last_updated' => Carbon::now()->toDateTimeString(),
            'updated_by' => null,
            'updated_by_name' => null
        ];
    }
    
    /**
     * Helper: Get all registrations from CSV
     */
    private function getAllRegistrations()
    {
        $csvPath = storage_path('app/' . $this->csvFile);
        $registrations = [];
        
        if (file_exists($csvPath)) {
            $file = fopen($csvPath, 'r');
            $headers = fgetcsv($file); // Read headers
            
            if ($headers !== false) {
                // Clean headers (remove BOM if exists)
                $headers = array_map(function($header) {
                    return trim($header, "\xEF\xBB\xBF");
                }, $headers);
                
                while (($row = fgetcsv($file)) !== false) {
                    // Skip total row
                    if (strtolower($row[0]) === 'total') {
                        continue;
                    }
                    
                    if (count($row) === count($headers)) {
                        $registrations[] = array_combine($headers, $row);
                    }
                }
            }
            
            fclose($file);
        }
        
        // Also check JSON backup for any missing data
        $jsonPath = storage_path('app/' . $this->jsonBackupFile);
        if (file_exists($jsonPath)) {
            $jsonData = json_decode(file_get_contents($jsonPath), true);
            if (is_array($jsonData)) {
                foreach ($jsonData as $jsonRegistration) {
                    $exists = false;
                    foreach ($registrations as $csvRegistration) {
                        if ($csvRegistration['id'] === $jsonRegistration['id']) {
                            $exists = true;
                            break;
                        }
                    }
                    if (!$exists) {
                        $registrations[] = $jsonRegistration;
                    }
                }
            }
        }
        
        return $registrations;
    }
    
    /**
     * Helper: Save registration to CSV
     */
    private function saveToCsv($data)
    {
        $csvPath = storage_path('app/' . $this->csvFile);
        
        // Check if file exists and has content
        $fileExists = file_exists($csvPath);
        $file = fopen($csvPath, $fileExists ? 'a' : 'w');
        
        // If new file, write headers
        if (!$fileExists || filesize($csvPath) === 0) {
            $headers = array_keys($data);
            fputcsv($file, $headers);
        }
        
        // Write data
        fputcsv($file, array_values($data));
        
        // Update total row
        $registrations = $this->getAllRegistrations();
        $total = count($registrations) + 1; // +1 for the new one
        
        // Remove existing total row if exists
        rewind($file);
        $lines = [];
        while (($line = fgetcsv($file)) !== false) {
            if (strtolower($line[0]) !== 'total') {
                $lines[] = $line;
            }
        }
        
        // Write all lines back
        $tempFile = tmpfile();
        fputcsv($tempFile, array_keys($data)); // Headers
        foreach ($lines as $line) {
            if ($line[0] !== 'id') { // Skip header in lines
                fputcsv($tempFile, $line);
            }
        }
        
        // Add total row
        $totalRow = array_fill(0, count($data), '');
        $totalRow[0] = 'Total';
        $totalRow[count($totalRow) - 1] = $total;
        fputcsv($tempFile, $totalRow);
        
        // Replace original file
        fclose($file);
        file_put_contents($csvPath, stream_get_contents($tempFile, -1, 0));
        fclose($tempFile);
    }
    
    /**
     * Helper: Save to JSON backup
     */
    private function saveToJsonBackup($data)
    {
        $jsonPath = storage_path('app/' . $this->jsonBackupFile);
        $backupData = [];
        
        if (file_exists($jsonPath)) {
            $backupData = json_decode(file_get_contents($jsonPath), true) ?? [];
        }
        
        // Check if already exists
        $exists = false;
        foreach ($backupData as &$item) {
            if ($item['id'] === $data['id']) {
                $item = $data;
                $exists = true;
                break;
            }
        }
        
        if (!$exists) {
            $backupData[] = $data;
        }
        
        file_put_contents($jsonPath, json_encode($backupData, JSON_PRETTY_PRINT));
    }
    
    /**
     * Helper: Save all registrations
     */
    private function saveAllRegistrations($registrations)
    {
        $csvPath = storage_path('app/' . $this->csvFile);
        $jsonPath = storage_path('app/' . $this->jsonBackupFile);
        
        // Save to CSV
        if (count($registrations) > 0) {
            $file = fopen($csvPath, 'w');
            $headers = array_keys($registrations[0]);
            fputcsv($file, $headers);
            
            foreach ($registrations as $registration) {
                fputcsv($file, array_values($registration));
            }
            
            // Add total row
            $totalRow = array_fill(0, count($headers), '');
            $totalRow[0] = 'Total';
            $totalRow[count($totalRow) - 1] = count($registrations);
            fputcsv($file, $totalRow);
            
            fclose($file);
        } else {
            file_put_contents($csvPath, 'id,nama,foto_path,kelas,tempat_lahir,tanggal_lahir,jenis_kelamin,alamat,no_hp,asal_sekolah,nama_ortu_wali,pengalaman_prestasi,penyakit_diderita,rutinitas_menghambat,tujuan,harapan,tanggal_ortu_wali,status,admin_id,created_at,email' . PHP_EOL . 'Total,,,,,,,,,,,,,,,,,,,,0');
        }
        
        // Save to JSON backup
        file_put_contents($jsonPath, json_encode($registrations, JSON_PRETTY_PRINT));
    }
}