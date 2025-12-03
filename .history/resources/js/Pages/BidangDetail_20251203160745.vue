<!-- src/pages/BidangDetail.vue -->
<template>
  <div class="min-h-screen bg-white py-12">
    <div class="max-w-5xl mx-auto px-4">

      <!-- Foto Grup (16:9) -->
      <div class="mb-8">
        <div class="w-full aspect-[16/9] bg-gray-200 rounded-xl flex items-center justify-center">
          <span class="text-gray-600">Foto Grup: {{ bidang.title }}</span>
        </div>
      </div>

      <!-- Judul Bidang -->
      <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-light text-blue-600 mb-4">{{ bidang.title }}</h1>
        <div class="w-16 h-0.5 bg-osisGold mx-auto"></div>
      </div>

      <!-- Tugas Umum -->
      <div class="text-center mb-12 max-w-3xl mx-auto">
        <p class="text-gray-700 text-lg leading-relaxed">
          {{ bidang.tugasUmum }}
        </p>
      </div>

      <!-- Ketua / Koordinator -->
      <div class="mb-16">
        <h2 class="text-2xl font-medium text-blue-600 mb-6 text-center">Ketua / Koordinator Bidang</h2>
        <div class="flex flex-col md:flex-row gap-8 items-center max-w-3xl mx-auto">
          <div class="w-28 h-28 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
            {{ getInitials(ketua.nama) }}
          </div>
          <div class="text-center md:text-left">
            <h3 class="text-xl font-semibold text-blue-600">{{ ketua.nama }}</h3>
            <p class="text-gray-600 mb-4">{{ ketua.jabatan }}</p>

            <!-- Tab Motto & Hobi (dipisahkan garis) -->
            <div class="border border-gray-300 rounded-md max-w-md mx-auto md:mx-0">
              <div class="grid grid-cols-2 text-center">
                <button
                  @click="activeTab.ketua = 'motto'"
                  :class="activeTab.ketua === 'motto' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                  class="py-2 font-medium transition-colors"
                >
                  Motto
                </button>
                <button
                  @click="activeTab.ketua = 'hobi'"
                  :class="activeTab.ketua === 'hobi' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                  class="py-2 font-medium transition-colors"
                >
                  Hobi
                </button>
              </div>
              <!-- Garis Pemisah -->
              <div class="border-t border-gray-300"></div>
              <div class="p-4 min-h-[80px]">
                <p v-if="activeTab.ketua === 'motto'">
                  {{ ketua.motto || '— Belum ada motto —' }}
                </p>
                <p v-else>
                  {{ ketua.hobi || '— Belum ada hobi —' }}
                </p>
              </div>
            </div>

            <!-- Timeline Ketua -->
            <div class="mt-6">
              <h4 class="font-medium text-blue-600 mb-2">Pengalaman Organisasi</h4>
              <div class="space-y-3">
                <div v-for="(exp, i) in ketua.pengalaman" :key="i" class="border-l-2 border-blue-600 pl-3 py-1">
                  <h5 class="font-medium text-gray-800">{{ exp.kegiatan }}</h5>
                  <p class="text-sm text-gray-600">{{ exp.tahun }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Anggota Tim -->
      <div v-if="anggotaTim.length" class="mb-12">
        <h2 class="text-2xl font-medium text-blue-600 mb-6 text-center">Anggota Tim</h2>
        <p class="text-gray-600 text-center mb-8">
          Terdiri dari {{ anggotaTim.length }} anggota.
        </p>

        <div class="space-y-12 max-w-4xl mx-auto">
          <div v-for="(anggota, idx) in anggotaTim" :key="anggota.id" class="flex flex-col md:flex-row gap-8 items-start">
            <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 text-xl font-bold">
              {{ getInitials(anggota.nama) }}
            </div>
            <div class="flex-1 max-w-3xl">
              <h3 class="text-lg font-semibold text-blue-600">{{ anggota.nama }}</h3>
              <p class="text-gray-600 mb-4">{{ anggota.jabatan }}</p>

              <!-- Tab Motto & Hobi (dipisahkan garis) -->
              <div class="border border-gray-300 rounded-md mb-4">
                <div class="grid grid-cols-2 text-center">
                  <button
                    @click="activeTab[anggota.id] = 'motto'"
                    :class="activeTab[anggota.id] === 'motto' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="py-1 font-medium transition-colors"
                  >
                    Motto
                  </button>
                  <button
                    @click="activeTab[anggota.id] = 'hobi'"
                    :class="activeTab[anggota.id] === 'hobi' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="py-1 font-medium transition-colors"
                  >
                    Hobi
                  </button>
                </div>
                <!-- Garis Pemisah -->
                <div class="border-t border-gray-300"></div>
                <div class="p-3 min-h-[70px]">
                  <p v-if="activeTab[anggota.id] === 'motto'">
                    {{ anggota.motto || '— Belum ada motto —' }}
                  </p>
                  <p v-else>
                    {{ anggota.hobi || '— Belum ada hobi —' }}
                  </p>
                </div>
              </div>

              <!-- Timeline -->
              <div>
                <h4 class="font-medium text-blue-600 mb-2">Pengalaman Organisasi</h4>
                <div class="space-y-2">
                  <div v-for="(exp, i) in anggota.pengalaman" :key="i" class="border-l-2 border-blue-600 pl-3 py-1">
                    <h5 class="font-medium text-gray-800">{{ exp.kegiatan }}</h5>
                    <p class="text-sm text-gray-600">{{ exp.tahun }}</p>
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
const activeTab = ref({ ketua: 'motto' })

const getInitials = (nama) => {
  return nama
    .split(' ')
    .slice(0, 2)
    .map(n => n[0])
    .join('')
    .toUpperCase()
}

// Data Bidang Lengkap
const bidangData = {
  inti: {
    title: 'Inti OSIS',
    tugasUmum: 'Mengawasi kerja setiap bidang dan koordinasi kegiatan bersama dengan guru dan pimpinan sekolah.',
    ketua: {
      id: 'inti-ketua',
      nama: 'Ahmad Fauzi',
      jabatan: 'Ketua OSIS',
      motto: 'Memimpin dengan hati, melayani dengan akhlak.',
      hobi: 'Membaca buku kepemimpinan dan bermain futsal.',
      pengalaman: [
        { kegiatan: 'Ketua Panitia Ma’arif Cup 2025', tahun: '2025' },
        { kegiatan: 'Koordinator Pengajian Rutin Jumat', tahun: '2024' }
      ]
    },
    anggota: [
      {
        id: 'inti-1',
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
        id: 'inti-2',
        nama: 'Rizky Pratama',
        jabatan: 'Sekretaris',
        motto: 'Disiplin dalam catatan, rapi dalam kerja.',
        hobi: 'Fotografi dan videografi.',
        pengalaman: [
          { kegiatan: 'Sekretaris Ma’arif Competition', tahun: '2024' },
          { kegiatan: 'Dokumentasi MTQ Sekolah', tahun: '2025' }
        ]
      },
      {
        id: 'inti-3',
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
    tugasUmum: 'Mengelola kegiatan keagamaan dan pembinaan akhlak siswa, dengan tujuan membentuk generasi yang beriman, bertakwa, dan berakhlak mulia.',
    ketua: {
      id: '1-ketua',
      nama: 'Ali Imron',
      jabatan: 'Koordinator Bidang I',
      motto: 'Ilmu tanpa amal sia-sia.',
      hobi: 'Menghafal Al-Qur’an dan berdakwah.',
      pengalaman: [
        { kegiatan: 'Koordinator PHBI Isra Mi’raj', tahun: '2025' },
        { kegiatan: 'Panitia Santunan Yatim', tahun: '2024' }
      ]
    },
    anggota: [
      {
        id: '1-1',
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
  // ... (tambahkan bidang 2–6 dengan pola serupa jika perlu)
  2: {
    title: 'Bidang II – Kesiswaan',
    tugasUmum: 'Menangani disiplin, tata tertib, dan pembinaan karakter siswa sesuai nilai-nilai luhur MA Ma’arif Udanawu.',
    ketua: { id: '2-ketua', nama: 'Budi Santoso', jabatan: 'Koordinator', motto: 'Disiplin itu ibadah.', hobi: 'Olahraga pagi.', pengalaman: [{ kegiatan: 'Pengawas Upacara', tahun: '2025' }] },
    anggota: []
  },
  3: {
    title: 'Bidang III – Olahraga & Seni',
    tugasUmum: 'Mengembangkan bakat siswa di bidang olahraga dan seni melalui kompetisi internal maupun eksternal.',
    ketua: { id: '3-ketua', nama: 'Citra Dewi', jabatan: 'Koordinator', motto: 'Berkreasi tanpa batas.', hobi: 'Menari dan menyanyi.', pengalaman: [{ kegiatan: 'Ketua Porseni', tahun: '2024' }] },
    anggota: []
  },
  4: {
    title: 'Bidang IV – Humas & Publikasi',
    tugasUmum: 'Mengelola komunikasi, dokumentasi, media sosial, dan hubungan dengan pihak luar.',
    ketua: { id: '4-ketua', nama: 'Dedi Firmansyah', jabatan: 'Koordinator', motto: 'Dokumentasi adalah sejarah.', hobi: 'Desain grafis.', pengalaman: [{ kegiatan: 'Admin Instagram OSIS', tahun: '2025' }] },
    anggota: []
  },
  5: {
    title: 'Bidang V – Sosial & Lingkungan',
    tugasUmum: 'Mendorong kepedulian sosial dan kelestarian lingkungan melalui aksi nyata.',
    ketua: { id: '5-ketua', nama: 'Eka Putri', jabatan: 'Koordinator', motto: 'Peduli itu ibadah.', hobi: 'Berkebun dan volunteer.', pengalaman: [{ kegiatan: 'Koordinator Jumat Bersih', tahun: '2024' }] },
    anggota: []
  },
  6: {
    title: 'Bidang VI – Kewirausahaan',
    tugasUmum: 'Melatih jiwa kewirausahaan siswa melalui usaha kecil dan pelatihan.',
    ketua: { id: '6-ketua', nama: 'Fauzan Rizki', jabatan: 'Koordinator', motto: 'Berkarya dan berbagi.', hobi: 'Membuat kerajinan.', pengalaman: [{ kegiatan: 'Ketua Bazar Produk Siswa', tahun: '2025' }] },
    anggota: []
  }
}

const bidang = computed(() => {
  const id = route.params.id
  return bidangData[id] || bidangData.inti
})

const ketua = computed(() => bidang.value.ketua)
const anggotaTim = computed(() => bidang.value.anggota || [])
</script>