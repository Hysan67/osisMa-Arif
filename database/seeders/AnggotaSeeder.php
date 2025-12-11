<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run()
    {
        // Data yang sudah ada (BPH)
        Anggota::create([
            'nama' => 'MUHAMAD HAIKAL',
            'posisi' => 'Ketua Umum',
            'kelas' => 'XI-B',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 1,
        ]);

        Anggota::create([
            'nama' => 'MIFTAHUL MUIZ',
            'posisi' => 'Ketua',
            'kelas' => 'XI-N',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 1,
        ]);

        Anggota::create([
            'nama' => 'BAGUS ETIAWAN',
            'posisi' => 'Ketua',
            'kelas' => 'X-B',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 1,
        ]);

        Anggota::create([
            'nama' => 'INTAN SONIA MUSA ADAH',
            'posisi' => 'Sekretaris Umum',
            'kelas' => 'XI-D',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 1,
        ]);

        Anggota::create([
            'nama' => 'KHAMIDATUL ULA NURUL FADILAH',
            'posisi' => 'Sekretaris',
            'kelas' => 'XI-H',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 1,
        ]);

        Anggota::create([
            'nama' => 'RAHIL KHULAIDA BASSAMA NASMA',
            'posisi' => 'Sekretaris',
            'kelas' => 'X-E',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 1,
        ]);

        Anggota::create([
            'nama' => 'INTAN RAHAYU PUTRI',
            'posisi' => 'Bendahara Umum',
            'kelas' => 'X-D',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 1,
        ]);

        Anggota::create([
            'nama' => 'LATIFATUS ZAHRO',
            'posisi' => 'Bendahara',
            'kelas' => 'X-J',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 1,
        ]);
        
        // ==================== DEPARTEMEN AGAMA (Bidang Keagamaan - ID: 4) ====================
        // Koordinator sudah ada di BPH (Miftahul Muiz)
        Anggota::create([
            'nama' => 'FARHAN HABIBI AHMADA',
            'posisi' => 'Ketua Departemen',
            'kelas' => 'XI-J',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        Anggota::create([
            'nama' => 'ROFIANO AL FAHRA AZAHRA',
            'posisi' => 'Anggota',
            'kelas' => 'XI-M',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        Anggota::create([
            'nama' => 'ELLSA SAHDANA',
            'posisi' => 'Anggota',
            'kelas' => 'XI-F',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        Anggota::create([
            'nama' => 'NAUFAL SULAIMAN',
            'posisi' => 'Anggota',
            'kelas' => 'X-A',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        Anggota::create([
            'nama' => 'DIMAS ATHA MAULANA',
            'posisi' => 'Anggota',
            'kelas' => 'X-L',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        Anggota::create([
            'nama' => 'M. YUFI ADITYA',
            'posisi' => 'Anggota',
            'kelas' => 'X-N',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        Anggota::create([
            'nama' => 'MAULUDYA FEBY F',
            'posisi' => 'Anggota',
            'kelas' => 'X-C',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        Anggota::create([
            'nama' => 'FARADINA NOVITA DEWI',
            'posisi' => 'Anggota',
            'kelas' => 'X-E',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        Anggota::create([
            'nama' => 'ZAHRA KANAYA SALSABILA',
            'posisi' => 'Anggota',
            'kelas' => 'X-E',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 4,
        ]);

        // ==================== DEPARTEMEN SENI DAN HUMAS (Bidang Seni & Humas - ID: 6) ====================
        // Koordinator sudah ada di BPH (Miftahul Muiz)
        Anggota::create([
            'nama' => 'M. KHOIRU NASUKHA',
            'posisi' => 'Ketua Departemen',
            'kelas' => 'XI-L',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 6,
        ]);

        Anggota::create([
            'nama' => 'YENI TRIMULYANINGSIH',
            'posisi' => 'Anggota',
            'kelas' => 'XI-H',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 6,
        ]);

        Anggota::create([
            'nama' => 'DISTIA DEWI NURROHMAH',
            'posisi' => 'Anggota',
            'kelas' => 'XI-I',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 6,
        ]);

        Anggota::create([
            'nama' => 'AHMAD FITO DZAKY A',
            'posisi' => 'Anggota',
            'kelas' => 'X-A',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 6,
        ]);

        Anggota::create([
            'nama' => 'M. IRWAN ARFA AZKA',
            'posisi' => 'Anggota',
            'kelas' => 'X-A',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 6,
        ]);

        Anggota::create([
            'nama' => 'SUCI NAKIA NAZARI',
            'posisi' => 'Anggota',
            'kelas' => 'X-E',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 6,
        ]);

        Anggota::create([
            'nama' => 'MECCA SAFIRA BALQIS M',
            'posisi' => 'Anggota',
            'kelas' => 'X-F',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 6,
        ]);

        // ==================== DEPARTEMEN KEAMANAN DAN KETERTIBAN (Bidang Keamanan & Ketertiban - ID: 2) ====================
        // Koordinator sudah ada di BPH (Miftahul Muiz)
        Anggota::create([
            'nama' => 'ARY WAHYUDI',
            'posisi' => 'Ketua Departemen',
            'kelas' => 'XI-L',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 2,
        ]);

        Anggota::create([
            'nama' => 'AL AMIRA MAHARANI NURUS SYIFAK',
            'posisi' => 'Anggota',
            'kelas' => 'XI-D',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 2,
        ]);

        Anggota::create([
            'nama' => 'IKFI NUZULA HABIBAH',
            'posisi' => 'Anggota',
            'kelas' => 'XI-H',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 2,
        ]);

        Anggota::create([
            'nama' => 'MUHAMMAD NAUFAL EXCEL K',
            'posisi' => 'Anggota',
            'kelas' => 'X-K',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 2,
        ]);

        Anggota::create([
            'nama' => 'KEVIN SURYA WIJAYA',
            'posisi' => 'Anggota',
            'kelas' => 'X-L',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 2,
        ]);

        Anggota::create([
            'nama' => 'JUNIOR ANGGARA PUTRA WAHAB',
            'posisi' => 'Anggota',
            'kelas' => 'X-O',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 2,
        ]);

        Anggota::create([
            'nama' => 'FATIHA HAILUNA IMAMA',
            'posisi' => 'Anggota',
            'kelas' => 'X-C',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 2,
        ]);

        Anggota::create([
            'nama' => 'LEILANI OLIVIA FAIRRAHMAN',
            'posisi' => 'Anggota',
            'kelas' => 'X-H',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 2,
        ]);

        // ==================== DEPARTEMEN OLAHRAGA (Bidang Olahraga - ID: 7) ====================
        // Koordinator sudah ada di BPH (Bagus Etiawan)
        Anggota::create([
            'nama' => 'FARHAN NUR ROKHIM',
            'posisi' => 'Ketua Departemen',
            'kelas' => 'XI-N',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 7,
        ]);

        Anggota::create([
            'nama' => 'AURELLIANZA DESTAVA',
            'posisi' => 'Anggota',
            'kelas' => 'XI-D',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 7,
        ]);

        Anggota::create([
            'nama' => 'TSANIA SHOFIATUN NADA',
            'posisi' => 'Anggota',
            'kelas' => 'XI-E',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 7,
        ]);

        Anggota::create([
            'nama' => 'CHARISMA SURYA APRILIYA',
            'posisi' => 'Anggota',
            'kelas' => 'XI-F',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 7,
        ]);

        Anggota::create([
            'nama' => 'M. RIFKY KHOIRUL HUDA',
            'posisi' => 'Anggota',
            'kelas' => 'X-B',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 7,
        ]);

        Anggota::create([
            'nama' => 'FEBIAN WIDYADANA',
            'posisi' => 'Anggota',
            'kelas' => 'X-M',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 7,
        ]);

        Anggota::create([
            'nama' => 'ALYSIA RAHMA IKHMADA',
            'posisi' => 'Anggota',
            'kelas' => 'X-D',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 7,
        ]);

        Anggota::create([
            'nama' => 'ANGGITA PUTRI ATMAGUNG',
            'posisi' => 'Anggota',
            'kelas' => 'X-G',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 7,
        ]);

        // ==================== DEPARTEMEN PRACARA (Bidang Pramuka & Upacara - ID: 3) ====================
        // Koordinator sudah ada di BPH (Bagus Etiawan)
        Anggota::create([
            'nama' => 'M. PAHASI',
            'posisi' => 'Ketua Departemen',
            'kelas' => 'XI-A',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 3,
        ]);

        Anggota::create([
            'nama' => 'M. AMRIZAL FEBRIANSYAH',
            'posisi' => 'Anggota',
            'kelas' => 'XI-L',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 3,
        ]);

        Anggota::create([
            'nama' => 'DEWI NISRINAA SYAMMAA',
            'posisi' => 'Anggota',
            'kelas' => 'XI-I',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 3,
        ]);

        Anggota::create([
            'nama' => 'IRSYAD SYAIFUDIN',
            'posisi' => 'Anggota',
            'kelas' => 'X-B',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 3,
        ]);

        Anggota::create([
            'nama' => 'M. AGHISNA ALBUSTAMI',
            'posisi' => 'Anggota',
            'kelas' => 'X-B',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 3,
        ]);

        Anggota::create([
            'nama' => 'NUR ANINDIYA TRI A.M',
            'posisi' => 'Anggota',
            'kelas' => 'X-C',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 3,
        ]);

        Anggota::create([
            'nama' => 'ELIZA FADILA PUTRI',
            'posisi' => 'Anggota',
            'kelas' => 'X-H',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 3,
        ]);

        // ==================== DEPARTEMEN KESEHATAN (Bidang Kesehatan - ID: 5) ====================
        // Koordinator sudah ada di BPH (Bagus Etiawan)
        Anggota::create([
            'nama' => 'FETTYRICHA ZAIAN HUSNA',
            'posisi' => 'Ketua Departemen',
            'kelas' => 'XI-D',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 5,
        ]);

        Anggota::create([
            'nama' => 'DEWI RATNA SARI',
            'posisi' => 'Anggota',
            'kelas' => 'XI-E',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 5,
        ]);

        Anggota::create([
            'nama' => 'MELIANA PUTRI RISNAWATI',
            'posisi' => 'Anggota',
            'kelas' => 'X-F',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 5,
        ]);

        Anggota::create([
            'nama' => 'WINDY AGUSTIN SETYANINGSIH',
            'posisi' => 'Anggota',
            'kelas' => 'X-H',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 5,
        ]);

        Anggota::create([
            'nama' => 'MAKAYLA ATHAYA',
            'posisi' => 'Anggota',
            'kelas' => 'X-J',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 5,
        ]);

        Anggota::create([
            'nama' => 'ZAHRA ONNI AMANDA',
            'posisi' => 'Anggota',
            'kelas' => 'X-J',
            'pengalaman_prestasi' => null,
            'status' => 'aktif',
            'bidang_id' => 5,
        ]);

        $this->command->info('Seeder Anggota berhasil dijalankan!');
        $this->command->info('Total anggota yang dimasukkan: ' . Anggota::count());
    }
}