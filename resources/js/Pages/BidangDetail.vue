<!-- src/pages/BidangDetail.vue -->
<template>
  <div class="min-h-screen bg-transparant py-16">
    <div class="max-w-4xl mx-auto px-4 py-16">
      <router-link to="/" class="text-blue-600 hover:underline mb-8 inline-block font-light" data-aos="fade-left" data-aos-delay="500">&larr; Kembali ke Beranda</router-link>

      <div v-if="!bidang" class="text-center py-16 text-gray-500">
        Halaman tidak ditemukan.
      </div>

      <div v-else>
        <!-- Judul -->
        <div class="text-center mb-16">
          <h1 class="text-5xl font-light text-blue-600 mb-6" data-aos="fade-right" data-aos-delay="500">{{ bidang.title }}</h1>
          <div class="w-16 h-px bg-yellow-300 mx-auto" data-aos="fade-left" data-aos-delay="500"></div>
          <p class="text-gray-700 mt-8 max-w-2xl mx-auto text-lg leading-relaxed" data-aos="zoom-in" data-aos-delay="500">{{ bidang.description }}</p>
        </div>

        <!-- Program Kerja -->
        <div class="mb-20">
          <h2 class="text-3xl font-light text-blue-600 mb-8" data-aos="fade-left" data-aos-delay="500">Program Kerja</h2>
          <ul class="space-y-4">
            <li v-for="(program, i) in bidang.programs" :key="i" class="flex items-start">
              <span class="text-blue-600 mr-3 mt-1" data-aos="fade-down" data-aos-delay="500">•</span>
              <span class="text-gray-800 font-light" data-aos="fade-up" data-aos-delay="500">{{ program }}</span>
            </li>
          </ul>
        </div>

        <!-- ⭐ TIMELINE PENGALAMAN (DITAMBAHKAN) -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-20">
          <h2 class="text-center text-gray-700 font-semibold tracking-wide mb-6">
            PENGALAMAN ORGANISASI & KEPANITIAAN
          </h2>

          <div class="space-y-8 relative">

            <!-- ITEM 1 -->
            <div class="flex items-start gap-4 relative">
              <div class="bg-white rounded-full p-1 z-10 relative">
               <div class="absolute -left-[3px] top-3 w-3 h-3 bg-[#1E40AF] rounded-full z-20"></div>
              </div>

              <div>
                <h3 class="font-semibold text-[#1E40AF] leading-tight">Koordinator Dana Zion Competition Gen 2</h3>
                <p class="text-sm text-gray-600">Kompetisi Zion Gen II TA 2024/2025</p>
              </div>
            </div>

            <!-- ITEM 2 -->
            <div class="flex items-start gap-4 relative">
              <div class="bg-white rounded-full p-1 z-10 relative">
               <div class="absolute -left-[3px] top-3 w-3 h-3 bg-[#1E40AF] rounded-full z-20"></div>
              </div>

              <div>
                <h3 class="font-semibold text-[#1E40AF] leading-tight">Sekretaris II Piala Zion VI</h3>
                <p class="text-sm text-gray-600">Panitia Sekretaris 2 ZION CUP Vol. VI Tahun 2025</p>
              </div>
            </div>

            <!-- ITEM 3 -->
            <div class="flex items-start gap-4 relative">
              <div class="bg-white rounded-full p-1 z-10 relative">
               <div class="absolute -left-[3px] top-3 w-3 h-3 bg-[#1E40AF] rounded-full z-20"></div>
              </div>

              <div>
                <h3 class="font-semibold text-[#1E40AF] leading-tight">Ketua Panitia Natal 2024</h3>
                <p class="text-sm text-gray-600">Perayaan Natal SMA Zion TA 2024–2025</p>
              </div>
            </div>

            <!-- ITEM 4 -->
            <div class="flex items-start gap-4 relative">
              <div class="bg-white rounded-full p-1 z-10 relative">
               <div class="absolute -left-[3px] top-3 w-3 h-3 bg-[#1E40AF] rounded-full z-20"></div>
              </div>

              <div>
                <h3 class="font-semibold text-[#1E40AF] leading-tight">Koordinator Lomba Balon Berantai HUT RI ke–79</h3>
                <p class="text-sm text-gray-600">HUT RI ke–79</p>
              </div>
            </div>

            <!-- ITEM 5 -->
            <div class="flex items-start gap-4 relative">
              <div class="bg-white rounded-full p-1 z-10 relative">
               <div class="absolute -left-[3px] top-3 w-3 h-3 bg-[#1E40AF] rounded-full z-20"></div>
              </div>

              <div>
                <h3 class="font-semibold text-[#1E40AF] leading-tight">Bendahara Porseni 2 TA 2023–2024</h3>
                <p class="text-sm text-gray-600">Pekan Olahraga & Seni 2 TA 2023–2024 SMA Zion</p>
              </div>
            </div>
          </div>
        </div>
        <!-- ⭐ END TIMELINE -->

<!-- ⭐ M O T T O  &  H O B I  (DINAMIS) -->
<div class="border border-gray-300 rounded-md overflow-hidden w-full max-w-3xl mx-auto mb-20">

  <!-- TAB HEADER -->
  <div class="grid grid-cols-2 text-center font-semibold">

    <button
      @click="activeTab = 'motto'"
      :class="activeTab === 'motto'
        ? 'bg-[#1E266D] text-white'
        : 'bg-gray-100 text-gray-700'"
      class="py-4 transition-colors duration-200"
    >
      Motto
    </button>

    <button
      @click="activeTab = 'hobi'"
      :class="activeTab === 'hobi'
        ? 'bg-[#1E266D] text-white'
        : 'bg-gray-100 text-gray-700'"
      class="py-4 transition-colors duration-200"
    >
      Hobi
    </button>

  </div>

  <!-- TAB CONTENT -->
  <div class="p-6 text-gray-800 text-lg leading-relaxed min-h-[120px]">

    <!-- Motto -->
    <p v-if="activeTab === 'motto'">
      {{ bidang.motto || '— Tidak ada motto —' }}
    </p>

    <!-- Hobi -->
    <p v-else>
      {{ bidang.hobi || '— Tidak ada hobi —' }}
    </p>

  </div>

</div>
<!-- ⭐ END MOTO & HOBI -->
        <!-- Ilustrasi Foto -->
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
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const activeTab = ref('motto') // ✔ DITAMBAHKAN — mendefinisikan tab aktif

const bidangData = {
  /* (isinya tetap, tidak diubah) */
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
