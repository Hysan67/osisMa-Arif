<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidang extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'img',
        'nama',
        'deskripsi',
        'tugas_umum',
    ];

    protected $dates = ['deleted_at'];

    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }
}