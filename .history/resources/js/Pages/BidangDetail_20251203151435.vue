<!-- src/pages/BidangDetail.vue -->
<template>
  <div class="min-h-screen bg-white py-16">
    <div class="max-w-4xl mx-auto px-4">
      <!-- Judul Bidang -->
      <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-light text-osisBlue mb-6">
          {{ bidang.title }}
        </h1>
        <div class="w-16 h-px bg-osisGold mx-auto"></div>
      </div>

      <!-- Tugas Umum (seperti di website referensi) -->
      <div class="mb-12 text-center">
        <h2 class="text-2xl font-light text-osisBlue mb-4">Tugas Umum</h2>
        <p class="text-gray-700 max-w-2xl mx-auto leading-relaxed">
          {{ getTugasUmum }}
        </p>
      </div>

      <!-- Deskripsi Bidang -->
      <div class="mb-16 text-center">
        <p class="text-gray-700 max-w-3xl mx-auto text-lg leading-relaxed">
          {{ bidang.description }}
        </p>
      </div>

      <!-- Program Kerja -->
      <div class="mb-16">
        <h2 class="text-3xl font-light text-osisBlue text-center mb-8">Program Kerja</h2>
        <ul class="space-y-3 max-w-2xl mx-auto">
          <li v-for="(program, i) in bidang.programs" :key="i" class="flex items-start">
            <span class="text-osisBlue mr-3 mt-1">•</span>
            <span class="text-gray-800">{{ program }}</span>
          </li>
        </ul>
      </div>

      <!-- Timeline Pengalaman (versi sederhana) -->
      <div class="mb-16">
        <h2 class="text-3xl font-light text-osisBlue text-center mb-8">Pengalaman Kepanitiaan</h2>
        <div class="space-y-6 max-w-2xl mx-auto">
          <div v-for="(item, index) in bidang.experiences || defaultExperiences" :key="index" class="border-l-2 border-osisBlue pl-4 py-1">
            <h3 class="font-medium text-osisBlue">{{ item.title }}</h3>
            <p class="text-sm text-gray-600 mt-1">{{ item.event }}</p>
          </div>
        </div>
      </div>

      <!-- Tab Motto & Hobi -->
      <div class="border border-gray-300 rounded-md overflow-hidden max-w-2xl mx-auto">
        <div class="grid grid-cols-2 text-center font-medium">
          <button
            @click="activeTab = 'motto'"
            :class="activeTab === 'motto' ? 'bg-osisBlue text-white' : 'bg-gray-100 text-gray-700'"
            class="py-3 transition-colors duration-200"
          >
            Motto
          </button>
          <button
            @click="activeTab = 'hobi'"
            :class="activeTab === 'hobi' ? 'bg-osisBlue text-white' : 'bg-gray-100 text-gray-700'"
            class="py-3 transition-colors duration-200"
          >
            Hobi
          </button>
        </div>
        <div class="p-6 text-gray-800 min-h-[100px]">
          <p v-if="activeTab === 'motto'">
            {{ bidang.motto || '— Belum ada motto —' }}
          </p>
          <p v-else>
            {{ bidang.hobi || '— Belum ada hobi —' }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const activeTab = ref('motto')

// Tugas Umum (sama untuk semua bidang, seperti di referensi)
const getTugasUmum = "Mengawasi kerja setiap bidang dan koordinasi kegiatan bersama dengan guru dan pimpinan sekolah."

// Pengalaman default (karena belum ada data spesifik per bidang)
const defaultExperiences = [
  { title: 'Koordinator Acara Hari Besar Islam', event: 'Peringatan Isra Mi’raj 2025' },
  { title: 'Bendahara Porseni', event: 'Pekan Olahraga dan Seni 2024' },
  { title: 'Ketua Panitia Bazar Amal', event: 'Bakti Sosial Yatim Piatu 2025' }
]

const bidangData = {
  inti: {
    title: 'Inti OSIS',
    description: 'Inti OSIS adalah jantung dari organisasi yang terdiri dari Ketua, Wakil Ketua, Sekretaris, dan Bendahara. Mereka bertugas mengkoordinir seluruh bidang, menyusun program kerja tahunan, dan menjadi penghubung antara siswa dengan pihak sekolah.',
    programs: [
      'Rapat Koordinasi Bulanan',
      'Evaluasi Program Kerja',
      'Pembinaan Pengurus Harian',
      'Laporan Kegiatan kepada Kepala Sekolah'
    ],
    motto: 'Memimpin dengan hati, melayani dengan akhlak.',
    hobi: 'Membaca, diskusi kepemimpinan, dan bermain futsal.',
    experiences: [
      { title: 'Ketua Panitia Ma’arif Cup 2025', event: 'Lomba Olahraga Antar Sekolah' },
      { title: 'Koordinator Pengajian Rutin', event: 'Kegiatan Keagamaan Jumat' }
    ]
  },
  1: {
    title: 'Bidang I – Kerohanian',
    description: 'Mengelola kegiatan keagamaan dan pembinaan akhlak, dengan tujuan membentuk generasi yang beriman, bertakwa, dan berakhlak mulia.',
    programs: [
      'Pengajian Rutin Setiap Jumat',
      'Peringatan Hari Besar Islam (PHBI)',
      'Bimbingan Sholat Dhuha',
      'Bakti Sosial & Santunan Yatim'
    ],
    motto: 'Ilmu tanpa amal sia-sia, amal tanpa ilmu sesat.',
    hobi: 'Menghafal Al-Qur’an, kaligrafi, dan berdakwah.',
    experiences: [
      { title: 'Koordinator PHBI Maulid Nabi', event: 'Perayaan 2024' },
      { title: 'Panitia Bakti Sosial', event: 'Santunan Anak Yatim 2025' }
    ]
  },
  // Lanjutkan untuk bidang 2–6 dengan struktur serupa...
  2: {
    title: 'Bidang II – Kesiswaan',
    description: 'Menangani disiplin, tata tertib, dan pembinaan karakter siswa sesuai nilai-nilai luhur MA Ma’arif Udanawu.',
    programs: [
      'Pembinaan Tata Tertib Sekolah',
      'Pelatihan Kepemimpinan Siswa',
      'Pengawasan Upacara Bendera',
      'Mediasi Konflik Antar Siswa'
    ],
    motto: 'Disiplin adalah pondasi kepribadian.',
    hobi: 'Menulis jurnal, olahraga pagi, dan mentoring siswa baru.',
    experiences: defaultExperiences
  },
  3: {
    title: 'Bidang III – Olahraga & Seni',
    description: 'Mengembangkan bakat siswa di bidang olahraga dan seni melalui kompetisi internal maupun eksternal.',
    programs: [
      'Porseni Antar Kelas',
      'Lomba Futsal & Voli',
      'Festival Seni Islami (Nasyid, Kaligrafi)',
      'Pelatihan Tari Saman & Rebana'
    ],
    motto: 'Berkreasi dengan jiwa, berolahraga dengan semangat.',
    hobi: 'Bermain musik, menari, dan fotografi.',
    experiences: defaultExperiences
  },
  4: {
    title: 'Bidang IV – Humas & Publikasi',
    description: 'Mengelola komunikasi, dokumentasi, media sosial, dan hubungan dengan pihak luar.',
    programs: [
      'Pengelolaan Instagram & YouTube OSIS',
      'Dokumentasi Foto & Video Kegiatan',
      'Desain Poster & Banner',
      'Kolaborasi dengan OSIS Sekolah Lain'
    ],
    motto: 'Dokumentasi adalah jejak sejarah perjuangan.',
    hobi: 'Desain grafis, videografi, dan konten kreator.',
    experiences: defaultExperiences
  },
  5: {
    title: 'Bidang V – Sosial & Lingkungan',
    description: 'Mendorong kepedulian sosial dan kelestarian lingkungan melalui aksi nyata.',
    programs: [
      'Gerakan Jumat Bersih',
      'Donor Darah & Bazar Amal',
      'Penanaman Pohon di Sekolah',
      'Kampanye Anti Narkoba'
    ],
    motto: 'Peduli itu ibadah.',
    hobi: 'Berkebun, volunteer, dan kampanye lingkungan.',
    experiences: defaultExperiences
  },
  6: {
    title: 'Bidang VI – Kewirausahaan',
    description: 'Melatih jiwa kewirausahaan siswa melalui usaha kecil dan pelatihan.',
    programs: [
      'Bazar Produk Siswa',
      'Pelatihan Sabun Herbal & Kerajinan',
      'Pameran Karya Kreatif',
      'Kolaborasi dengan UMKM Lokal'
    ],
    motto: 'Berkarya, berusaha, dan berbagi.',
    hobi: 'Membuat kerajinan tangan, kuliner, dan berjualan online.',
    experiences: defaultExperiences
  }
}

const bidang = computed(() => {
  const id = route.params.id
  return bidangData[id] || null
})
</script>