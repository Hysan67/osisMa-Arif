<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\User;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();

        Artikel::create([
            'judul' => 'Artikel Pertama',
            'deskripsi' => 'Ini adalah artikel pertama.',
            'jenis_artikel' => 'artikel',
            'admin_id' => $admin->id,
        ]);

        Artikel::create([
            'judul' => 'Event Besar',
            'deskripsi' => 'Ini adalah event besar.',
            'jenis_artikel' => 'event',
            'admin_id' => $admin->id,
        ]);
    }
}