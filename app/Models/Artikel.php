<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Artikel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'img',
        'judul',
        'deskripsi',
        'jenis_artikel',
        'admin_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}