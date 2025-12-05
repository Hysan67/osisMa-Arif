<!-- src/pages/BidangDetail.vue -->
<template>
  <div class="min-h-screen bg-white py-8">

      <!-- FOTO BESAR -->
    <div
      class="w-full aspect-[16/9] bg-gray-200 rounded-none overflow-hidden"
    >
      <img
        v-if="bidang.headerPhoto"
        :src="bidang.headerPhoto"
        :alt="'Foto ' + bidang.title"
        class="w-full h-full object-cover"
        data-aos="fade-right"
        :data-aos-delay="bidang.headerPhoto * 500"
      />

      <!-- fallback kalau headerPhoto belum diisi -->
      <div v-else class="w-full h-full flex items-center justify-center text-gray-600">
        Foto Grup: {{ bidang.title }}
      </div>
    </div>


    <div class="max-w-5xl mx-auto px-4 py-12">

      <!-- Judul Bidang -->
      <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-light text-blue-600 mb-4"  data-aos="zoom-in" data-aos-delay="500">{{ bidang.title }}</h1>
        <div class="w-16 h-0.5 bg-osisGold mx-auto"></div>
      </div>

      <!-- Tugas Umum -->
      <div class="text-center mb-12 max-w-3xl mx-auto">
        <p class="text-gray-700 text-lg leading-relaxed" data-aos="fade-left" data-aos-delay="500">
          {{ bidang.tugasUmum }}
        </p>
      </div>

      <!-- Ketua / Koordinator -->
      <div class="mb-16">
        <h2 class="text-2xl font-medium text-blue-600 mb-6 text-center" data-aos="fade-right" data-aos-delay="500">Ketua / Koordinator Bidang</h2>
        <div class="flex flex-col md:flex-row gap-8 items-center max-w-3xl mx-auto">
          <div class="w-28 h-28 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold" data-aos="flip-left" data-aos-delay="500">
            {{ getInitials(ketua.nama) }}
          </div>
          <div class="text-center md:text-left">
            <h3 class="text-xl font-semibold text-blue-600" data-aos="fade-up" data-aos-delay="500">{{ ketua.nama }}</h3>
            <p class="text-gray-600 mb-4" data-aos="fade-up" data-aos-delay="500">{{ ketua.jabatan }}</p>

            <!-- Tab Motto & Hobi -->
            <div class="border border-gray-300 rounded-md max-w-md mx-auto md:mx-0" data-aos="fade-up" data-aos-delay="500">
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
              <h4 class="font-medium text-blue-600 mb-2"  data-aos="fade-up" data-aos-delay="500">Pengalaman Organisasi</h4>
              <div class="space-y-3">
                <div v-for="(exp, i) in ketua.pengalaman" :key="i" class="border-l-2 border-blue-600 pl-3 py-1"  data-aos="fade-up" data-aos-delay="500">
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
        <h2 class="text-2xl font-medium text-blue-600 mb-6 text-center" data-aos="fade-right" data-aos-delay="500">Anggota Tim</h2>
        <p class="text-gray-600 text-center mb-8" data-aos="fade-left" data-aos-delay="500">
          Terdiri dari {{ anggotaTim.length }} anggota.
        </p>

        <div class="space-y-12 max-w-4xl mx-auto">
          <div v-for="(anggota, idx) in anggotaTim" :key="anggota.id" class="flex flex-col md:flex-row gap-8 items-start">
            <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 text-xl font-bold" data-aos="flip-left" data-aos-delay="500">
              {{ getInitials(anggota.nama) }}
            </div>
            <div class="flex-1 max-w-3xl">
              <h3 class="text-lg font-semibold text-blue-600" data-aos="fade-up" data-aos-delay="500">{{ anggota.nama }}</h3>
              <p class="text-gray-600 mb-4" data-aos="fade-up" data-aos-delay="500">{{ anggota.jabatan }}</p>

              <!-- Tab Motto & Hobi -->
              <div class="border border-gray-300 rounded-md mb-4" data-aos="fade-up" data-aos-delay="500">
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
                <h4 class="font-medium text-blue-600 mb-2" data-aos="fade-up" data-aos-delay="500">Pengalaman Organisasi</h4>
                <div class="space-y-2" data-aos="fade-up" data-aos-delay="500">
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

      <!-- Apa yang Kami Lakukan -->
      <div class="mt-16 bg-gray-50 py-12">
        <div class="max-w-5xl mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-light text-blue-600 mb-4" data-aos="fade-right" data-aos-delay="500">Apa yang kami lakukan.</h2>
          <p class="text-gray-600 mb-12 max-w-3xl" data-aos="fade-left" data-aos-delay="500">
            {{ bidang.aktivitasDeskripsi }}
          </p>

          <div class="grid md:grid-cols-2 gap-8" data-aos="fade-up" data-aos-delay="500">
            <div v-for="(aktivitas, i) in bidang.aktivitas" :key="i" class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-10 h-10 rounded-full bg-pink-500 flex items-center justify-center text-white">
                <span v-html="getIcon(aktivitas.icon)"></span>
              </div>
              <div>
                <h3 class="text-xl font-semibold text-blue-600">{{ aktivitas.judul }}</h3>
                <p class="text-gray-700 mt-2">{{ aktivitas.deskripsi }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto Slider Dokumentasi -->
      <div class="mt-12" data-aos="flip-left" data-aos-delay="500">
        <h3 class="text-xl font-medium text-blue-600 mb-4">Dokumentasi Kegiatan</h3>
        <PhotoSlider :photos="bidang.photos" />
      </div>
      <br/>
      <br
      <router-link to="/event" class="text-blue-600 hover:underline mb-8 inline-block font-light" data-aos="fade-left" data-aos-delay="500">&larr; Kembali ke Daftar Event</router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import PhotoSlider from '../Pages/PhotoSlider.vue'

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
1:{
  title: "Badan Pengurus Harian (BPH)",
  headerPhoto: "../bidang1.jpg",

  tugasUmum: "Mengkoordinasikan seluruh bidang OSIS",

  ketua: {
    id: '1-ketua',
    nama: "Nama Ketua BPH",
    jabatan: "Ketua Bidang BPH",
    motto: "Motto hidup ketua BPH.",
    hobi: "Membaca, organisasi",
    pengalaman: [
      { kegiatan: "Panitia classmeeting", tahun: "2023" },
      { kegiatan: "Koordinator OSIS", tahun: "2024" }
    ]
  },

  anggota: [
    {
      id: '1-1',
      nama: "Nama Anggota 1",
      jabatan: "Anggota BPH",
      motto: "Motto anggota 1.",
      hobi: "Desain grafis",
      pengalaman: [
        { kegiatan: "Panitia lomba 17an", tahun: "2023" }
      ]
    },
    {
      id: '1-2',
      nama: "Nama Anggota 2",
      jabatan: "Anggota BPH",
      motto: "Motto anggota 2.",
      hobi: "Organisasi",
      pengalaman: [
        { kegiatan: "MC upacara", tahun: "2024" }
      ]
    }
  ],

  aktivitasDeskripsi:
    "BPH menjalankan fungsi koordinasi, administrasi, dan kepemimpinan organisasi OSIS.",

  aktivitas: [
    {
      icon: "sosial",
      judul: "Rapat Bulanan",
      deskripsi: "Evaluasi dan penyusunan agenda kegiatan OSIS."
    },
    {
      icon: "sosial",
      judul: "Administrasi OSIS",
      deskripsi: "Mengelola surat, notulen, dan dokumen penting."
    }
  ],

  photos: [
    { src: "/img/bidang/bph/1.jpg", alt: "Foto kegiatan BPH" },
    { src: "/img/bidang/bph/2.jpg", alt: "Rapat BPH" }
  ]
},

2:{
  title: "Bidang Keamanan & Ketertiban",
  headerPhoto: "../bidang2.jpg",

  tugasUmum:"Menjaga ketertiban saat kegiatan sekolah",

  ketua: {
    id: '2-ketua',
    nama: "Nama Ketua Keamanan",
    jabatan: "Ketua Bidang Keamanan & Ketertiban",
    motto: "Disiplin adalah kunci.",
    hobi: "Beladiri, olahraga",
    pengalaman: [
      { kegiatan: "Piket keamanan sekolah", tahun: "2024" }
    ]
  },

  anggota: [
    {
      id: '2-1',
      nama: "Nama Anggota 1",
      jabatan: "Anggota Keamanan",
      motto: "Tertib membuat nyaman.",
      hobi: "PBB",
      pengalaman: [
        { kegiatan: "Pengamanan event sekolah", tahun: "2023" }
      ]
    }
  ],

  aktivitasDeskripsi:
    "Bidang Keamanan memastikan seluruh kegiatan sekolah berjalan tertib dan aman.",

  aktivitas: [
    {
      icon: "sosial",
      judul: "Piket Harian",
      deskripsi: "Bertugas menjaga ketertiban di lingkungan sekolah."
    },
    {
      icon: "sosial",
      judul: "Pengaturan Barisan",
      deskripsi: "Mengatur barisan upacara dan kegiatan besar."
    }
  ],

  photos: [
    { src: "/img/bidang/keamanan/1.jpg", alt: "Tim keamanan piket" },
    { src: "/img/bidang/keamanan/2.jpg", alt: "Pengamanan acara" }
  ]
},
3:{
  title: "Bidang Pramuka & Upacara",
  headerPhoto: "../bidang3.jpg",

  tugasUmum:"Mengorganisir petugas upacara",

  ketua: {
    id: '3-ketua',
    nama: "Nama Ketua Pramuka",
    jabatan: "Ketua Bidang Pramuka & Upacara",
    motto: "Disiplin dan siap beraksi.",
    hobi: "PBB, hiking",
    pengalaman: [
      { kegiatan: "Ketua regu Pramuka", tahun: "2023" }
    ]
  },

  anggota: [
    {
      id: '3-1',
      nama: "Nama Anggota 1",
      jabatan: "Anggota Pramuka",
      motto: "Siaga, tangguh, siap.",
      hobi: "Camping",
      pengalaman: [
        { kegiatan: "Petugas upacara", tahun: "2024" }
      ]
    }
  ],

  aktivitasDeskripsi:
    "Bidang ini aktif dalam kegiatan pramuka, PBB, dan persiapan upacara sekolah.",

  aktivitas: [
    {
      icon: "sosial",
      judul: "Petugas Upacara",
      deskripsi: "Mengatur dan menyiapkan petugas upacara."
    },
    {
      icon: "sosial",
      judul: "Kegiatan Pramuka",
      deskripsi: "Koordinasi latihan dan kegiatan ekstrakurikuler."
    }
  ],

  photos: [
    { src: "/img/bidang/pramuka/1.jpg", alt: "Latihan PBB" },
    { src: "/img/bidang/pramuka/2.jpg", alt: "Petugas upacara" }
  ]
},
4:{
  title: "Bidang Keagamaan",
  headerPhoto: "../bidang4.jpg",

  tugasUmum: "Mengadakan kegiatan keagamaan rutin",

  ketua: {
    id: '4-ketua',
    nama: "Nama Ketua Keagamaan",
    jabatan: "Ketua Bidang Keagamaan",
    motto: "Ibadah adalah cahaya.",
    hobi: "Mengaji",
    pengalaman: [
      { kegiatan: "Koordinator PHBI", tahun: "2024" }
    ]
  },

  anggota: [
    {
      id: '4-1',
      nama: "Nama Anggota 1",
      jabatan: "Anggota Keagamaan",
      motto: "Belajar tanpa henti.",
      hobi: "Ceramah",
      pengalaman: [
        { kegiatan: "Petugas kultum", tahun: "2023" }
      ]
    }
  ],

  aktivitasDeskripsi:
    "Bidang Keagamaan mengisi kegiatan rohani dan pembinaan akhlak di sekolah.",

  aktivitas: [
    {
      icon: "sosial",
      judul: "Kultum Rutin",
      deskripsi: "Pembinaan rohani siswa setelah sholat dhuha."
    },
    {
      icon: "sosial",
      judul: "PHBI",
      deskripsi: "Peringatan hari besar Islam."
    }
  ],

  photos: [
    { src: "/img/bidang/keagamaan/1.jpg", alt: "Kegiatan keagamaan" },
    { src: "/img/bidang/keagamaan/2.jpg", alt: "Kultum siswa" }
  ]
},
5:{
  title: "Bidang Kesehatan",
  headerPhoto: "../bidang5.jpg",

  tugasUmum:"Memonitor kondisi kesehatan siswa",

  ketua: {
    id: '5-ketua',
    nama: "Nama Ketua Kesehatan",
    jabatan: "Ketua Bidang Kesehatan",
    motto: "Sehat itu investasi.",
    hobi: "Olahraga, membaca artikel kesehatan",
    pengalaman: [
      { kegiatan: "Relawan UKS", tahun: "2023" },
      { kegiatan: "Penyuluhan kesehatan", tahun: "2024" }
    ]
  },

  anggota: [
    {
      id: '5-1',
      nama: "Nama Anggota 1",
      jabatan: "Anggota Kesehatan",
      motto: "Tubuh sehat, pikiran sehat.",
      hobi: "Yoga",
      pengalaman: [
        { kegiatan: "Piket kesehatan sekolah", tahun: "2024" }
      ]
    }
  ],

  aktivitasDeskripsi:
    "Bidang Kesehatan bertanggung jawab menjaga kesehatan siswa dan mengadakan kegiatan edukasi kesehatan.",

  aktivitas: [
    {
      icon: "sosial",
      judul: "Piket UKS",
      deskripsi: "Menjaga kesiapsiagaan dan pertolongan pertama bagi siswa."
    },
    {
      icon: "sosial",
      judul: "Edukasi Kesehatan",
      deskripsi: "Memberikan penyuluhan tentang hidup sehat."
    }
  ],

  photos: [
    { src: "/img/bidang/kesehatan/1.jpg", alt: "Kegiatan UKS" },
    { src: "/img/bidang/kesehatan/2.jpg", alt: "Penyuluhan kesehatan" }
  ]
},
6:{
  title: "Bidang Seni & Humas",
  headerPhoto: "../bidang6.jpg",

  tugasUmum: "Mengelola dokumentasi kegiatan sekolah",

  ketua: {
    id: '6-ketua',
    nama: "Nama Ketua Seni & Humas",
    jabatan: "Ketua Bidang Seni & Humas",
    motto: "Kreativitas tanpa batas.",
    hobi: "Fotografi, desain grafis",
    pengalaman: [
      { kegiatan: "Panitia dokumentasi sekolah", tahun: "2023" },
      { kegiatan: "Koordinator media sosial", tahun: "2024" }
    ]
  },

  anggota: [
    {
      id: '6-1',
      nama: "Nama Anggota 1",
      jabatan: "Anggota Seni & Humas",
      motto: "Seni menyatukan kita.",
      hobi: "Melukis",
      pengalaman: [
        { kegiatan: "Pengelola poster acara", tahun: "2024" }
      ]
    }
  ],

  aktivitasDeskripsi:
    "Bidang Seni & Humas bertugas mengelola komunikasi, dokumentasi, dan promosi kegiatan OSIS.",

  aktivitas: [
    {
      icon: "sosial",
      judul: "Dokumentasi Kegiatan",
      deskripsi: "Mengambil foto dan video kegiatan sekolah."
    },
    {
      icon: "sosial",
      judul: "Kegiatan Seni",
      deskripsi: "Melatih dan menampilkan bakat seni siswa."
    }
  ],

  photos: [
    { src: "/img/bidang/seni/1.jpg", alt: "Dokumentasi acara" },
    { src: "/img/bidang/seni/2.jpg", alt: "Pertunjukan seni siswa" }
  ]
},
7:{
  title: "Bidang Olahraga",
  headerPhoto: "../bidang7.jpg",

  tugasUmum:"Mengorganisir kegiatan olahraga sekolah",

  ketua: {
    id: '7-ketua',
    nama: "Nama Ketua Olahraga",
    jabatan: "Ketua Bidang Olahraga",
    motto: "Sehat dan kuat bersama tim.",
    hobi: "Basket, renang",
    pengalaman: [
      { kegiatan: "Pelatih ekstrakurikuler basket", tahun: "2023" },
      { kegiatan: "Panitia lomba olahraga", tahun: "2024" }
    ]
  },

  anggota: [
    {
      id: '7-1',
      nama: "Nama Anggota 1",
      jabatan: "Anggota Olahraga",
      motto: "Bermain, berlatih, menang.",
      hobi: "Sepak bola",
      pengalaman: [
        { kegiatan: "Tim futsal sekolah", tahun: "2024" }
      ]
    }
  ],

  aktivitasDeskripsi:
    "Bidang Olahraga memfasilitasi kegiatan fisik, pelatihan tim, dan lomba olahraga di sekolah.",

  aktivitas: [
    {
      icon: "sosial",
      judul: "Latihan Tim",
      deskripsi: "Melatih tim ekstrakurikuler untuk kompetisi."
    },
    {
      icon: "sosial",
      judul: "Lomba Olahraga",
      deskripsi: "Menyelenggarakan lomba dan turnamen internal."
    }
  ],

  photos: [
    { src: "/img/bidang/olahraga/1.jpg", alt: "Latihan tim olahraga" },
    { src: "/img/bidang/olahraga/2.jpg", alt: "Turnamen sekolah" }
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

// Navigasi ke bidang selanjutnya
const nextBidangPath = computed(() => {
  const id = parseInt(route.params.id)
  const nextId = id + 1
  if (nextId > 6) return '/inti'
  return `/bidang/${nextId}`
})
</script>