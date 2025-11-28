<!-- src/pages/BidangDetail.vue -->
<template>
  <div class="min-h-screen bg-transparant py-16">
    <div class="max-w-4xl mx-auto px-4 py-16">
      <router-link to="/" class="text-blue-600 hover:underline mb-8 inline-block font-light">&larr; Kembali ke Beranda</router-link>

      <div v-if="!bidang" class="text-center py-16 text-gray-500">
        Halaman tidak ditemukan.
      </div>

      <div v-else>
        <!-- Judul -->
        <div class="text-center mb-16">
          <h1 class="text-5xl font-light text-blue-600 mb-6">{{ bidang.title }}</h1>
          <div class="w-16 h-px bg-yellow-300 mx-auto"></div>
          <p class="text-gray-700 mt-8 max-w-2xl mx-auto text-lg leading-relaxed">{{ bidang.description }}</p>
        </div>

        <!-- Program Kerja -->
        <div class="mb-20">
          <h2 class="text-3xl font-light text-blue-600 mb-8">Program Kerja</h2>
          <ul class="space-y-4">
            <li v-for="(program, i) in bidang.programs" :key="i" class="flex items-start">
              <span class="text-blue-600 mr-3 mt-1">•</span>
              <span class="text-gray-800 font-light">{{ program }}</span>
            </li>
          </ul>
        </div>

        <!-- Ilustrasi Foto (jika nanti ada) -->
        <div class="rounded-2xl overflow-hidden shadow-sm">
          <div class="aspect-video bg-gray-200 flex items-center justify-center">
            <span class="text-gray-600">Dokumentasi: {{ bidang.title }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const bidangData = {
  // ... (sama seperti sebelumnya, tidak perlu diubah)
  inti: {
    title: 'Inti OSIS',
    description: 'Inti OSIS adalah jantung dari organisasi yang terdiri dari Ketua, Wakil Ketua, Sekretaris, dan Bendahara. Mereka bertugas mengkoordinir seluruh bidang, menyusun program kerja tahunan, dan menjadi penghubung antara siswa dengan pihak sekolah.',
    programs: [
      'Rapat Koordinasi Bulanan',
      'Evaluasi Program Kerja',
      'Pembinaan Pengurus Harian',
      'Laporan Kegiatan kepada Kepala Sekolah'
    ]
  },
  1: {
    title: 'Bidang I – Kerohanian',
    description: 'Bidang ini mengelola seluruh kegiatan keagamaan dan pembinaan akhlak siswa, dengan tujuan membentuk generasi yang beriman, bertakwa, dan berakhlak mulia.',
    programs: [
      'Pengajian Rutin Setiap Jumat',
      'Peringatan Hari Besar Islam (PHBI)',
      'Bimbingan Sholat Dhuha',
      'Bakti Sosial & Santunan Yatim'
    ]
  },
  2: {
    title: 'Bidang II – Kesiswaan',
    description: 'Bertanggung jawab atas kedisiplinan, tata tertib, dan pembinaan karakter siswa sesuai nilai-nilai luhur MA Ma’arif Udanawu.',
    programs: [
      'Pembinaan Tata Tertib Sekolah',
      'Pelatihan Kepemimpinan Siswa',
      'Pengawasan Upacara Bendera',
      'Mediasi Konflik Antar Siswa'
    ]
  },
  3: {
    title: 'Bidang III – Olahraga & Seni',
    description: 'Mengembangkan bakat dan minat siswa di bidang olahraga dan seni melalui kompetisi internal maupun eksternal.',
    programs: [
      'Porseni Antar Kelas',
      'Lomba Futsal & Voli',
      'Festival Seni Islami (Nasyid, Kaligrafi)',
      'Pelatihan Tari Saman & Rebana'
    ]
  },
  4: {
    title: 'Bidang IV – Humas & Publikasi',
    description: 'Mengelola komunikasi internal dan eksternal OSIS, termasuk dokumentasi, media sosial, dan hubungan dengan pihak luar.',
    programs: [
      'Pengelolaan Instagram & YouTube OSIS',
      'Dokumentasi Foto & Video Kegiatan',
      'Desain Poster & Banner',
      'Kolaborasi dengan OSIS Sekolah Lain'
    ]
  },
  5: {
    title: 'Bidang V – Sosial & Lingkungan',
    description: 'Mendorong kepedulian sosial dan kelestarian lingkungan melalui aksi nyata yang melibatkan seluruh siswa.',
    programs: [
      'Gerakan Jumat Bersih',
      'Donor Darah & Bazar Amal',
      'Penanaman Pohon di Sekolah',
      'Kampanye Anti Narkoba'
    ]
  },
  6: {
    title: 'Bidang VI – Kewirausahaan',
    description: 'Melatih jiwa kewirausahaan siswa melalui kegiatan usaha kecil, pelatihan, dan pameran produk kreatif.',
    programs: [
      'Bazar Produk Siswa Setiap Bulan',
      'Pelatihan Sabun Herbal & Kerajinan',
      'Pameran Karya Kreatif',
      'Kolaborasi dengan UMKM Lokal'
    ]
  }
}

const bidang = computed(() => {
  const id = route.params.id
  return bidangData[id] || null
})
</script>