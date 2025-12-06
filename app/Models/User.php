<?php

namespace App\Models;

// Pastikan trait ini diimpor
use Illuminate\Foundation\Auth\User as Authenticatable; // Atau model dasar lainnya
use Laravel\Sanctum\HasApiTokens; // <-- Import trait Sanctum

// Gunakan trait Sanctum di class User
class User extends Authenticatable // <-- Nama kelas harus 'User', bukan 'user'
{
    use HasApiTokens; // <-- Tambahkan ini

    // ... properti dan method lainnya
    protected $fillable = [
        'name',
        'email',
        'password',
        // ... tambahkan kolom lain yang bisa diisi massal
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ... relasi atau method lainnya
}