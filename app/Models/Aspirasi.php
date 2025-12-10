<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kelas',
        'email',
        'judul',
        'pesan',
        'balasan',
        'status',
        'admin_id',
        'email_sent',
        'email_sent_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'email_sent' => 'boolean',
    ];

    // Status constants
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIBALAS = 'dibalas';
    const STATUS_DITOLAK = 'ditolak';
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scope for filtering
    public function scopeMenunggu($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }
    
    public function scopeSudahDibalas($query)
    {
        return $query->where('status', self::STATUS_DIBALAS);
    }
    
    public function scopeWithEmail($query)
    {
        return $query->whereNotNull('email')
                    ->where('email', '!=', '');
    }
}