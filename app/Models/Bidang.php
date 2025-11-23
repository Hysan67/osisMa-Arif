<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    //
    protected $fillable = [
        'img',
        'nama',
        'deskripsi',
        'tugas_umum',
    ];

    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }
}
