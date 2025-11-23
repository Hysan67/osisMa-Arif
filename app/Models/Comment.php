<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'pesan',
        'artikel_id',
        'anggota_id',
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }

}