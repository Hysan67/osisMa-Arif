<!-- src/pages/BidangDetail.vue -->
<template>
  <div class="min-h-screen bg-white py-12">
    <div class="max-w-5xl mx-auto px-4">

      <!-- Foto Grup (Full Width, 16:9) -->
      <div class="mb-8">
        <div class="w-full aspect-[16/9] bg-gray-200 rounded-xl flex items-center justify-center">
          <span class="text-gray-600">Foto Grup: {{ bidang.title }}</span>
        </div>
      </div>

      <!-- Judul Bidang -->
      <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-light text-osisBlue mb-4">{{ bidang.title }}</h1>
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
        <h2 class="text-2xl font-medium text-osisBlue mb-6 text-center">Ketua / Koordinator Bidang</h2>
        <div class="flex flex-col md:flex-row gap-8 items-center max-w-3xl mx-auto">
          <div class="w-28 h-28 rounded-full bg-osisBlue flex items-center justify-center text-white text-2xl font-bold">
            {{ getInitials(ketua.nama) }}
          </div>
          <div class="text-center md:text-left">
            <h3 class="text-xl font-semibold text-osisBlue">{{ ketua.nama }}</h3>
            <p class="text-gray-600 mb-4">{{ ketua.jabatan }}</p>

            <!-- Tab Motto & Hobi -->
            <div class="border border-gray-300 rounded-md max-w-md mx-auto md:mx-0">
              <div class="grid grid-cols-2 text-center">
                <button
                  @click="activeTab.ketua = 'motto'"
                  :class="activeTab.ketua === 'motto' ? 'bg-osisBlue text-white' : 'bg-gray-100 text-gray-700'"
                  class="py-2 font-medium transition-colors"
                >
                  Motto
                </button>
                <button
                  @click="activeTab.ketua = 'hobi'"
                  :class="activeTab.ketua === 'hobi' ? 'bg-osisBlue text-white' : 'bg-gray-100 text-gray-700'"
                  class="py-2 font-medium transition-colors"
                >
                  Hobi
                </button>
              </div>
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

            <!-- Timeline -->
            <div class="mt-6">
              <h4 class="font-medium text-osisBlue mb-2">Pengalaman Organisasi</h4>
              <div class="space-y-3">
                <div v-for="(exp, i) in ketua.pengalaman" :key="i" class="border-l-2 border-osisBlue pl-3 py-1">
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
        <h2 class="text-2xl font-medium text-osisBlue mb-6 text-center">Anggota Tim</h2>
        <p class="text-gray-600 text-center mb-8">
          Terdiri dari {{ anggotaTim.length }} anggota.
        </p>

        <div class="space-y-12 max-w-4xl mx-auto">
          <div v-for="(anggota, idx) in anggotaTim" :key="anggota.id" class="flex flex-col md:flex-row gap-8 items-start">
            <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 text-xl font-bold">
              {{ getInitials(anggota.nama) }}
            </div>
            <div class="flex-1 max-w-3xl">
              <h3 class="text-lg font-semibold text-osisBlue">{{ anggota.nama }}</h3>
              <p class="text-gray-600 mb-4">{{ anggota.jabatan }}</p>

              <!-- Tab Motto & Hobi -->
              <div class="border border-gray-300 rounded-md mb-4">
                <div class="grid grid-cols-2 text-center">
                  <button
                    @click="activeTab[anggota.id] = 'motto'"
                    :class="activeTab[anggota.id] === 'motto' ? 'bg-osisBlue text-white' : 'bg-gray-100 text-gray-700'"
                    class="py-1 font-medium transition-colors"
                  >
                    Motto
                  </button>
                  <button
                    @click="activeTab[anggota.id] = 'hobi'"
                    :class="activeTab[anggota.id] === 'hobi' ? 'bg-osisBlue text-white' : 'bg-gray-100 text-gray-700'"
                    class="py-1 font-medium transition-colors"
                  >
                    Hobi
                  </button>
                </div>
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
                <h4 class="font-medium text-osisBlue mb-2">Pengalaman Organisasi</h4>
                <div class="space-y-2">
                  <div v-for="(exp, i) in anggota.pengalaman" :key="i" class="border-l-2 border-osisBlue pl-3 py-1">
                    <h5 class="font-medium text-gray-800">{{ exp.kegiatan }}</h5>
                    <p class="text-sm text-gray-600">{{ exp.tahun }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 🔥 Apa yang Kami Lakukan -->
      <div class="mt-16 bg-gray-50 py-12">
        <div class="max-w-5xl mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-light text-osisBlue mb-4">Apa yang kami lakukan.</h2>
          <p class="text-gray-600 mb-12 max-w-3xl">
            {{ bidang.aktivitasDeskripsi }}
          </p>

          <div class="grid md:grid-cols-2 gap-8">
            <div v-for="(aktivitas, i) in bidang.aktivitas" :key="i" class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-10 h-10 rounded-full bg-pink-500 flex items-center justify-center text-white">
                <span v-html="getIcon(aktivitas.icon)"></span>
              </div>
              <div>
                <h3 class="text-xl font-semibold text-osisBlue">{{ aktivitas.judul }}</h3>
                <p class="text-gray-700 mt-2">{{ aktivitas.deskripsi }}</p>
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

const getIcon = (name) => {
  const icons = {
    ibadah: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7v10c0 5.55 3.84 6.77 9 11 5.16-4.23 9-5.45 9-11V7l-10-5z"/></svg>`,
    lomba: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>`,
    disiplin: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 6.77 9 11 5.16-4.23 9-5.45 9-11V5l-9-4zm0 18.08c-3.31-2.77-6-4.8-6-8.08 0-.94.22-1.82.61-2.58L12 6.09l5.39 2.33c.39.76.61 1.64.61 2.58 0 3.28-2.69 5.31-6 8.08z"/></svg>`,
    lingkungan: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>`,
    bisnis: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>`,
    publikasi: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>`,
    seni: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12,3L1,9L12,15L21,10.09V17H23V9M5,13.18V17H9V13.18L12,15L5,13.18Z"/></svg>`,
    sosial: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/></svg>`
  }
  return icons[name] || icons.ibadah
}

// Data Lengkap Semua Bidang
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
      { id: 'inti-1', nama: 'Dinda Rahmawati', jabatan: 'Wakil Ketua', motto: 'Kerja sama adalah kunci keberhasilan.', hobi: 'Menulis puisi.', pengalaman: [{ kegiatan: 'Wakil Ketua Bazar Amal', tahun: '2024' }] },
      { id: 'inti-2', nama: 'Rizky Pratama', jabatan: 'Sekretaris', motto: 'Disiplin dalam catatan.', hobi: 'Fotografi.', pengalaman: [{ kegiatan: 'Sekretaris Ma’arif Competition', tahun: '2024' }] },
      { id: 'inti-3', nama: 'Siti Nurhaliza', jabatan: 'Bendahara', motto: 'Uang bukan segalanya.', hobi: 'Berhitung.', pengalaman: [{ kegiatan: 'Bendahara Porseni', tahun: '2024' }] }
    ],
    aktivitasDeskripsi: 'Inti OSIS bertugas mengkoordinasi seluruh kegiatan OSIS, menyusun program kerja tahunan, dan menjadi penghubung antara siswa dengan pihak sekolah.',
    aktivitas: [
      { icon: 'disiplin', judul: 'Rapat Koordinasi', deskripsi: 'Mengadakan rapat bulanan dengan semua bidang untuk evaluasi dan perencanaan.' },
      { icon: 'publikasi', judul: 'Laporan Kegiatan', deskripsi: 'Menyusun laporan kegiatan untuk diserahkan kepada kepala sekolah.' },
      { icon: 'ibadah', judul: 'Pembinaan Harian', deskripsi: 'Memberikan arahan dan pendampingan kepada pengurus harian.' },
      { icon: 'sosial', judul: 'Koordinasi Antar Bidang', deskripsi: 'Memastikan semua bidang bekerja sama dalam setiap acara besar.' }
    ]
  },
  1: {
    title: 'Bidang I – Kerohanian',
    tugasUmum: 'Mengelola kegiatan keagamaan dan pembinaan akhlak siswa, dengan tujuan membentuk generasi yang beriman, bertakwa, dan berakhlak mulia.',
    ketua: { id: '1-ketua', nama: 'Ali Imron', jabatan: 'Koordinator', motto: 'Ilmu tanpa amal sia-sia.', hobi: 'Menghafal Al-Qur’an.', pengalaman: [{ kegiatan: 'Koordinator PHBI Isra Mi’raj', tahun: '2025' }] },
    anggota: [{ id: '1-1', nama: 'Fatimah Zahra', jabatan: 'Anggota', motto: 'Hidup untuk beribadah.', hobi: 'Kaligrafi.', pengalaman: [{ kegiatan: 'Pemandu Sholat Dhuha', tahun: '2024' }] }],
    aktivitasDeskripsi: 'Bidang ini fokus pada pembinaan spiritual dan kegiatan keagamaan yang mendorong siswa menjadi pribadi yang bertakwa.',
    aktivitas: [
      { icon: 'ibadah', judul: 'Pengajian Rutin', deskripsi: 'Mengadakan pengajian setiap Jumat pagi untuk seluruh siswa.' },
      { icon: 'ibadah', judul: 'Peringatan PHBI', deskripsi: 'Mengatur perayaan Hari Besar Islam seperti Isra Mi’raj dan Maulid Nabi.' },
      { icon: 'sosial', judul: 'Bakti Sosial', deskripsi: 'Mengadakan santunan anak yatim dan donasi untuk panti asuhan.' },
      { icon: 'ibadah', judul: 'Bimbingan Sholat', deskripsi: 'Membimbing sholat dhuha dan sholat dzuhur berjamaah.' }
    ]
  },
  2: {
    title: 'Bidang II – Kesiswaan',
    tugasUmum: 'Menangani disiplin, tata tertib, dan pembinaan karakter siswa sesuai nilai-nilai luhur MA Ma’arif Udanawu.',
    ketua: { id: '2-ketua', nama: 'Budi Santoso', jabatan: 'Koordinator', motto: 'Disiplin itu ibadah.', hobi: 'Olahraga pagi.', pengalaman: [{ kegiatan: 'Pengawas Upacara', tahun: '2025' }] },
    anggota: [],
    aktivitasDeskripsi: 'Bidang ini bertanggung jawab atas kedisiplinan, tata tertib, dan pembinaan karakter siswa sesuai nilai-nilai luhur MA Ma’arif Udanawu.',
    aktivitas: [
      { icon: 'disiplin', judul: 'Upacara Bendera', deskripsi: 'Mengatur dan mengawasi pelaksanaan upacara setiap hari Senin.' },
      { icon: 'disiplin', judul: 'Jaga Pagi', deskripsi: 'Melakukan penjagaan di gerbang sekolah saat jam masuk.' },
      { icon: 'disiplin', judul: 'Mediasi Konflik', deskripsi: 'Menjadi penengah dalam konflik antar siswa secara adil.' },
      { icon: 'sosial', judul: 'Pelatihan Karakter', deskripsi: 'Mengadakan pelatihan kepemimpinan dan akhlak mulia.' }
    ]
  },
  3: {
    title: 'Bidang III – Olahraga & Seni',
    tugasUmum: 'Mengembangkan bakat siswa di bidang olahraga dan seni melalui kompetisi internal maupun eksternal.',
    ketua: { id: '3-ketua', nama: 'Citra Dewi', jabatan: 'Koordinator', motto: 'Berkreasi tanpa batas.', hobi: 'Menari dan menyanyi.', pengalaman: [{ kegiatan: 'Ketua Porseni', tahun: '2024' }] },
    anggota: [],
    aktivitasDeskripsi: 'Bidang ini mewadahi bakat siswa dalam olahraga dan seni, baik tradisional maupun modern.',
    aktivitas: [
      { icon: 'seni', judul: 'Porseni Antar Kelas', deskripsi: 'Mengadakan lomba olahraga dan seni setiap semester.' },
      { icon: 'seni', judul: 'Festival Seni Islami', deskripsi: 'Mengadakan lomba nasyid, kaligrafi, dan rebana.' },
      { icon: 'lomba', judul: 'Lomba Futsal & Voli', deskripsi: 'Mengkoordinir turnamen antar kelas dan sekolah.' },
      { icon: 'seni', judul: 'Pelatihan Tari Saman', deskripsi: 'Memberikan pelatihan tari tradisional kepada siswa.' }
    ]
  },
  4: {
    title: 'Bidang IV – Humas & Publikasi',
    tugasUmum: 'Mengelola komunikasi, dokumentasi, media sosial, dan hubungan dengan pihak luar.',
    ketua: { id: '4-ketua', nama: 'Dedi Firmansyah', jabatan: 'Koordinator', motto: 'Dokumentasi adalah sejarah.', hobi: 'Desain grafis.', pengalaman: [{ kegiatan: 'Admin Instagram OSIS', tahun: '2025' }] },
    anggota: [],
    aktivitasDeskripsi: 'Bidang ini bertugas mendokumentasikan kegiatan dan mengelola media sosial OSIS.',
    aktivitas: [
      { icon: 'publikasi', judul: 'Pengelolaan Media Sosial', deskripsi: 'Mengelola Instagram dan YouTube OSIS.' },
      { icon: 'publikasi', judul: 'Dokumentasi Foto & Video', deskripsi: 'Mendokumentasikan setiap kegiatan OSIS.' },
      { icon: 'publikasi', judul: 'Desain Poster', deskripsi: 'Membuat desain promosi untuk setiap event.' },
      { icon: 'sosial', judul: 'Kolaborasi Eksternal', deskripsi: 'Menjalin kerja sama dengan OSIS sekolah lain.' }
    ]
  },
  5: {
    title: 'Bidang V – Sosial & Lingkungan',
    tugasUmum: 'Mendorong kepedulian sosial dan kelestarian lingkungan melalui aksi nyata.',
    ketua: { id: '5-ketua', nama: 'Eka Putri', jabatan: 'Koordinator', motto: 'Peduli itu ibadah.', hobi: 'Berkebun.', pengalaman: [{ kegiatan: 'Koordinator Jumat Bersih', tahun: '2024' }] },
    anggota: [],
    aktivitasDeskripsi: 'Bidang ini menggerakkan siswa untuk peduli terhadap sesama dan lingkungan sekitar.',
    aktivitas: [
      { icon: 'sosial', judul: 'Gerakan Jumat Bersih', deskripsi: 'Membersihkan lingkungan sekolah setiap Jumat.' },
      { icon: 'sosial', judul: 'Donor Darah', deskripsi: 'Mengadakan kegiatan donor darah bersama PMI.' },
      { icon: 'lingkungan', judul: 'Penanaman Pohon', deskripsi: 'Mengadakan penanaman pohon di area sekolah.' },
      { icon: 'sosial', judul: 'Kampanye Anti Narkoba', deskripsi: 'Memberikan edukasi tentang bahaya narkoba.' }
    ]
  },
  6: {
    title: 'Bidang VI – Kewirausahaan',
    tugasUmum: 'Melatih jiwa kewirausahaan siswa melalui usaha kecil dan pelatihan.',
    ketua: { id: '6-ketua', nama: 'Fauzan Rizki', jabatan: 'Koordinator', motto: 'Berkarya dan berbagi.', hobi: 'Membuat kerajinan.', pengalaman: [{ kegiatan: 'Ketua Bazar Produk Siswa', tahun: '2025' }] },
    anggota: [],
    aktivitasDeskripsi: 'Bidang ini melatih jiwa kewirausahaan siswa melalui kegiatan usaha dan pelatihan.',
    aktivitas: [
      { icon: 'bisnis', judul: 'Bazar Produk Siswa', deskripsi: 'Mengadakan bazar produk kreatif setiap bulan.' },
      { icon: 'bisnis', judul: 'Pelatihan Sabun Herbal', deskripsi: 'Memberikan pelatihan membuat sabun alami.' },
      { icon: 'bisnis', judul: 'Pameran Karya Kreatif', deskripsi: 'Menampilkan hasil karya siswa kepada publik.' },
      { icon: 'sosial', judul: 'Kolaborasi UMKM', deskripsi: 'Bekerja sama dengan pelaku UMKM lokal.' }
    ]
  }
}

const bidang = computed(() => {
  const id = route.params.id
  const data = bidangData[id] || bidangData.inti

  // Inisialisasi tab untuk ketua dan anggota
  activeTab.value.ketua = 'motto'
  data.anggota?.forEach(a => {
    if (!activeTab.value[a.id]) {
      activeTab.value = { ...activeTab.value, [a.id]: 'motto' }
    }
  })

  return data
})

const ketua = computed(() => bidang.value.ketua)
const anggotaTim = computed(() => bidang.value.anggota || [])
</script>