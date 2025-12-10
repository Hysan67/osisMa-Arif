<?php
// database/seeders/BidangSeeder.php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key check untuk menghindari error
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Bidang::truncate(); // Hapus data lama jika ada
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $bidangs = [
            [
                'id' => 1,
                'img' => 'bidang1.jpg',
                'nama' => 'Badan Pengurus Harian (BPH)',
                'deskripsi' => 'BPH menjalankan fungsi koordinasi, administrasi, dan kepemimpinan organisasi OSIS.',
                'tugas_umum' => 'Mengkoordinasikan seluruh bidang OSIS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'img' => 'bidang2.jpg',
                'nama' => 'Bidang Keamanan & Ketertiban',
                'deskripsi' => 'Bidang Keamanan memastikan seluruh kegiatan sekolah berjalan tertib dan aman.',
                'tugas_umum' => 'Menjaga ketertiban saat kegiatan sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'img' => 'bidang3.jpg',
                'nama' => 'Bidang Pramuka & Upacara',
                'deskripsi' => 'Bidang ini aktif dalam kegiatan pramuka, PBB, dan persiapan upacara sekolah.',
                'tugas_umum' => 'Mengorganisir petugas upacara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'img' => 'bidang4.jpg',
                'nama' => 'Bidang Keagamaan',
                'deskripsi' => 'Bidang Keagamaan mengisi kegiatan rohani dan pembinaan akhlak di sekolah.',
                'tugas_umum' => 'Mengadakan kegiatan keagamaan rutin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'img' => 'bidang5.jpg',
                'nama' => 'Bidang Kesehatan',
                'deskripsi' => 'Bidang Kesehatan bertanggung jawab menjaga kesehatan siswa dan mengadakan kegiatan edukasi kesehatan.',
                'tugas_umum' => 'Memonitor kondisi kesehatan siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'img' => 'bidang6.jpg',
                'nama' => 'Bidang Seni & Humas',
                'deskripsi' => 'Bidang Seni & Humas bertugas mengelola komunikasi, dokumentasi, dan promosi kegiatan OSIS.',
                'tugas_umum' => 'Mengelola dokumentasi kegiatan sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'img' => 'bidang7.jpg',
                'nama' => 'Bidang Olahraga',
                'deskripsi' => 'Bidang Olahraga memfasilitasi kegiatan fisik, pelatihan tim, dan lomba olahraga di sekolah.',
                'tugas_umum' => 'Mengorganisir kegiatan olahraga sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data ke database
        foreach ($bidangs as $bidang) {
            Bidang::create($bidang);
        }

        $this->command->info('Seeder Bidang berhasil dijalankan!');
        $this->command->info('Jumlah data yang dimasukkan: ' . count($bidangs));
    }
}