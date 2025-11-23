<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'img',
        'nama',
        'posisi',
        'quote',
        'pengalaman_prestasi',
        'masa_bakti',
        'status',
        'bidang_id',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
}