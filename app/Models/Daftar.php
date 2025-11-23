<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Daftar extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'nama',
        'foto',
        'kelas',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'asal_sekolah',
        'nama_ortu_wali',
        'pengalaman_prestasi',
        'penyakit_diderita',
        'rutinitas_menghambat',
        'tujuan',
        'harapan',
        'tanggal_ortu_wali',
        'status',
        'admin_id',
    ];

    // Relasi: daftar bisa disetujui oleh satu admin (opsional)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}