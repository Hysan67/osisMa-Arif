<!-- src/pages/BidangDetail.vue -->
<template>
  <div class="min-h-screen bg-white py-12">
    <div class="max-w-5xl mx-auto px-4">

      <!-- Foto Grup (Placeholder) -->
      <div class="mb-10">
        <div class="aspect-video bg-gray-200 rounded-xl flex items-center justify-center">
          <span class="text-gray-600">Foto Grup: {{ bidang.title }}</span>
        </div>
      </div>

      <!-- Judul Bidang -->
      <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-light text-blue-600 mb-4">
          {{ bidang.title }}
        </h1>
        <div class="w-16 h-0.5 bg-osisGold mx-auto"></div>
      </div>

      <!-- Daftar Anggota -->
      <div class="space-y-16">
        <div v-for="(anggota, idx) in bidang.anggota" :key="idx" class="border-b border-gray-200 pb-12">
          <div class="flex flex-col md:flex-row gap-8 items-start">
            <!-- Avatar Inisial -->
            <div class="flex-shrink-0">
              <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                {{ getInitials(anggota.nama) }}
              </div>
            </div>

            <!-- Profil -->
            <div class="flex-1 max-w-3xl">
              <h2 class="text-2xl font-medium text-blue-600">{{ anggota.nama }}</h2>
              <p class="text-gray-600 mb-6">{{ anggota.jabatan }}</p>

              <!-- Tab Motto & Hobi -->
              <div class="border border-gray-300 rounded-md mb-6">
                <div class="grid grid-cols-2 text-center">
                  <button
                    @click="activeTab[anggota.id] = 'motto'"
                    :class="activeTab[anggota.id] === 'motto' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="py-2 font-medium transition-colors"
                  >
                    Motto
                  </button>
                  <button
                    @click="activeTab[anggota.id] = 'hobi'"
                    :class="activeTab[anggota.id] === 'hobi' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="py-2 font-medium transition-colors"
                  >
                    Hobi
                  </button>
                </div>
                <div class="p-4 min-h-[80px]">
                  <p v-if="activeTab[anggota.id] === 'motto'">
                    {{ anggota.motto || '— Belum ada motto —' }}
                  </p>
                  <p v-else>
                    {{ anggota.hobi || '— Belum ada hobi —' }}
                  </p>
                </div>
              </div>

              <!-- Timeline Pengalaman -->
              <div>
                <h3 class="text-xl font-medium text-blue-600 mb-3">Pengalaman Kepanitiaan</h3>
                <div class="space-y-4">
                  <div v-for="(exp, i) in anggota.pengalaman" :key="i" class="border-l-2 border-blue-600 pl-4">
                    <h4 class="font-medium text-gray-800">{{ exp.kegiatan }}</h4>
                    <p class="text-sm text-gray-600 mt-1">{{ exp.tahun }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

// Inisialisasi tab per anggota
const activeTab = ref({})

const getInitials = (nama) => {
  return nama
    .split(' ')
    .slice(0, 2)
    .map(n => n[0])
    .join('')
    .toUpperCase()
}

// Data Dummy untuk Bidang
const bidangData = {
  inti: {
    title: 'Inti OSIS',
    anggota: [
      {
        id: 'inti-1',
        nama: 'Ahmad Fauzi',
        jabatan: 'Ketua OSIS',
        motto: 'Memimpin dengan hati, melayani dengan akhlak.',
        hobi: 'Membaca buku kepemimpinan dan bermain futsal.',
        pengalaman: [
          { kegiatan: 'Ketua Panitia Ma’arif Cup 2025', tahun: '2025' },
          { kegiatan: 'Koordinator Pengajian Rutin Jumat', tahun: '2024' }
        ]
      },
      {
        id: 'inti-2',
        nama: 'Dinda Rahmawati',
        jabatan: 'Wakil Ketua OSIS',
        motto: 'Kerja sama adalah kunci keberhasilan.',
        hobi: 'Menulis puisi dan desain poster.',
        pengalaman: [
          { kegiatan: 'Wakil Ketua Bazar Amal', tahun: '2024' },
          { kegiatan: 'Panitia Porseni', tahun: '2023' }
        ]
      },
      {
        id: 'inti-3',
        nama: 'Rizky Pratama',
        jabatan: 'Sekretaris',
        motto: 'Disiplin dalam catatan, rapi dalam kerja.',
        hobi: 'Fotografi dan videografi.',
        pengalaman: [
          { kegiatan: 'Sekretaris Zion Competition', tahun: '2024' },
          { kegiatan: 'Dokumentasi MTQ Sekolah', tahun: '2025' }
        ]
      },
      {
        id: 'inti-4',
        nama: 'Siti Nurhaliza',
        jabatan: 'Bendahara',
        motto: 'Uang bukan segalanya, tapi pengelolaan itu segalanya.',
        hobi: 'Berhitung dan membuat laporan keuangan.',
        pengalaman: [
          { kegiatan: 'Bendahara Porseni', tahun: '2024' },
          { kegiatan: 'Pengelola Dana Bakti Sosial', tahun: '2025' }
        ]
      }
    ]
  },
  1: {
    title: 'Bidang I – Kerohanian',
    anggota: [
      {
        id: '1-1',
        nama: 'Ali Imron',
        jabatan: 'Koordinator Bidang I',
        motto: 'Ilmu tanpa amal sia-sia.',
        hobi: 'Menghafal Al-Qur’an dan berdakwah.',
        pengalaman: [
          { kegiatan: 'Koordinator PHBI Isra Mi’raj', tahun: '2025' },
          { kegiatan: 'Panitia Santunan Yatim', tahun: '2024' }
        ]
      },
      {
        id: '1-2',
        nama: 'Fatimah Zahra',
        jabatan: 'Anggota',
        motto: 'Hidup untuk beribadah.',
        hobi: 'Kaligrafi dan ceramah agama.',
        pengalaman: [
          { kegiatan: 'Pemandu Sholat Dhuha', tahun: '2024' },
          { kegiatan: 'Lomba MTQ Internal', tahun: '2025' }
        ]
      }
    ]
  },
  // Bisa ditambahkan bidang 2–6 dengan pola yang sama...
  2: { title: 'Bidang II – Kesiswaan', anggota: [{ id: '2-1', nama: 'Budi Santoso', jabatan: 'Koordinator', motto: 'Disiplin itu ibadah.', hobi: 'Olahraga pagi.', pengalaman: [{ kegiatan: 'Pengawas Upacara', tahun: '2025' }] }] },
  3: { title: 'Bidang III – Olahraga & Seni', anggota: [{ id: '3-1', nama: 'Citra Dewi', jabatan: 'Koordinator', motto: 'Berkreasi tanpa batas.', hobi: 'Menari dan menyanyi.', pengalaman: [{ kegiatan: 'Ketua Porseni', tahun: '2024' }] }] },
  4: { title: 'Bidang IV – Humas & Publikasi', anggota: [{ id: '4-1', nama: 'Dedi Firmansyah', jabatan: 'Koordinator', motto: 'Dokumentasi adalah sejarah.', hobi: 'Desain grafis.', pengalaman: [{ kegiatan: 'Admin Instagram OSIS', tahun: '2025' }] }] },
  5: { title: 'Bidang V – Sosial & Lingkungan', anggota: [{ id: '5-1', nama: 'Eka Putri', jabatan: 'Koordinator', motto: 'Peduli itu ibadah.', hobi: 'Berkebun dan volunteer.', pengalaman: [{ kegiatan: 'Koordinator Jumat Bersih', tahun: '2024' }] }] },
  6: { title: 'Bidang VI – Kewirausahaan', anggota: [{ id: '6-1', nama: 'Fauzan Rizki', jabatan: 'Koordinator', motto: 'Berkarya dan berbagi.', hobi: 'Membuat kerajinan.', pengalaman: [{ kegiatan: 'Ketua Bazar Produk Siswa', tahun: '2025' }] }] }
}

const bidang = computed(() => {
  const id = route.params.id
  const data = bidangData[id] || bidangData.inti
  // Inisialisasi tab untuk setiap anggota
  data.anggota.forEach(a => {
    if (!activeTab.value[a.id]) {
      activeTab.value = { ...activeTab.value, [a.id]: 'motto' }
    }
  })
  return data
})
</script>