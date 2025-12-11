<!-- src/pages/BidangDetail.vue -->
<template>
  <div class="min-h-screen bg-white py-8">

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center h-96">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="text-center py-12">
      <div class="text-red-600 mb-4">
        <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
      </div>
      <h2 class="text-xl font-semibold text-gray-800 mb-2">Gagal memuat data</h2>
      <p class="text-gray-600 mb-4">{{ error }}</p>
      <button @click="fetchBidangData" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        Coba Lagi
      </button>
    </div>

    <!-- Content -->
    <div v-else>
      <!-- FOTO BESAR -->
      <div class="w-full aspect-[16/9] bg-gray-200 rounded-none overflow-hidden">
        <img
          v-if="bidang.headerPhoto"
          :src="bidang.headerPhoto"
          :alt="'Foto ' + bidang.nama"
          class="w-full h-full object-cover"
          data-aos="flip-left"
          data-aos-delay="500"
        />

        <!-- fallback kalau headerPhoto belum diisi -->
        <div v-else class="w-full h-full flex items-center justify-center text-gray-600 bg-gradient-to-r from-blue-50 to-indigo-50">
          <div class="text-center">
            <div class="text-6xl mb-4">👥</div>
            <p class="text-xl font-medium">{{ bidang.nama }}</p>
            <p class="text-sm text-gray-500 mt-2">Masa Bakti 2025/2026</p>
          </div>
        </div>
      </div>

      <div class="max-w-5xl mx-auto px-4 py-12">

        <!-- Judul Bidang -->
        <div class="text-center mb-8">
          <h1 class="text-4xl md:text-5xl font-light text-blue-600 mb-4" data-aos="zoom-in" data-aos-delay="500">{{ bidang.nama }}</h1>
          <div class="w-16 h-0.5 bg-osisGold mx-auto"></div>
          <p class="text-gray-600 mt-4">ID Bidang: {{ route.params.id }}</p>
        </div>

        <!-- Tugas Umum -->
        <div class="text-center mb-12 max-w-3xl mx-auto">
          <p class="text-gray-700 text-lg leading-relaxed" data-aos="fade-left" data-aos-delay="500">
            {{ bidang.tugas_umum }}
          </p>
        </div>

        <!-- STATISTIK BIDANG -->
        <div class="grid grid-cols-3 gap-4 mb-12 max-w-3xl mx-auto">
          <div class="bg-blue-50 rounded-lg p-4 text-center" data-aos="fade-up" data-aos-delay="300">
            <div class="text-2xl font-bold text-blue-600">{{ koordinator.length }}</div>
            <div class="text-sm text-gray-600">Koordinator</div>
          </div>
          <div class="bg-green-50 rounded-lg p-4 text-center" data-aos="fade-up" data-aos-delay="400">
            <div class="text-2xl font-bold text-green-600">{{ ketuaDepartemen.length }}</div>
            <div class="text-sm text-gray-600">Ketua Dept</div>
          </div>
          <div class="bg-purple-50 rounded-lg p-4 text-center" data-aos="fade-up" data-aos-delay="500">
            <div class="text-2xl font-bold text-purple-600">{{ anggotaTim.length }}</div>
            <div class="text-sm text-gray-600">Anggota</div>
          </div>
        </div>

        <!-- Koordinator -->
        <div class="mb-16" v-if="koordinator.length > 0">
          <h2 class="text-2xl font-medium text-blue-600 mb-6 text-center" data-aos="fade-right" data-aos-delay="500">Koordinator Bidang</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div v-for="(koor, index) in koordinator" :key="'koor-' + index" 
                 class="bg-white rounded-xl shadow-lg p-6 border border-gray-100" 
                 data-aos="fade-up" :data-aos-delay="index * 200 + 500">
              
              <!-- Foto/Inisial -->
              <div class="flex items-center gap-4 mb-4">
                <div class="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                  {{ getInitials(koor.nama) }}
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-blue-600">{{ koor.nama }}</h3>
                  <p class="text-gray-600 text-sm">{{ koor.posisi }}</p>
                  <p class="text-gray-500 text-xs">{{ koor.kelas }}</p>
                </div>
              </div>

              <!-- Informasi Kelas -->
              <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                  </svg>
                  <span class="font-medium">Kelas</span>
                </div>
                <div class="mt-2">
                  <p class="text-lg font-semibold text-blue-800">{{ koor.kelas }}</p>
                  <p class="text-sm text-gray-600">Angkatan {{ getAngkatanFromKelas(koor.kelas) }}</p>
                </div>
              </div>

              <!-- Pengalaman (jika ada) -->
              <div v-if="hasPengalaman(koor)" class="mt-4">
                <div class="flex items-center text-green-700 mb-2">
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                  </svg>
                  <span class="font-medium">Pengalaman</span>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                  <p class="text-gray-700 text-sm">{{ formatPengalaman(koor.pengalaman_prestasi) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Ketua Departemen -->
        <div class="mb-16" v-if="ketuaDepartemen.length > 0">
          <h2 class="text-2xl font-medium text-blue-600 mb-6 text-center" data-aos="fade-right" data-aos-delay="500">Ketua Departemen</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div v-for="(ketua, index) in ketuaDepartemen" :key="'ketua-' + index" 
                 class="bg-white rounded-xl shadow-lg p-6" 
                 data-aos="fade-up" :data-aos-delay="index * 200 + 500">
              
              <!-- Foto/Inisial -->
              <div class="flex flex-col items-center text-center mb-6">
                <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-bold mb-4">
                  {{ getInitials(ketua.nama) }}
                </div>
                <div>
                  <h3 class="text-xl font-semibold text-blue-600">{{ ketua.nama }}</h3>
                  <p class="text-gray-600">{{ ketua.posisi }}</p>
                </div>
              </div>

              <!-- Dua Kolom: Kelas dan Pengalaman -->
              <div class="grid grid-cols-2 gap-4">
                <!-- Kolom Kelas -->
                <div class="bg-blue-50 rounded-lg p-4">
                  <div class="flex items-center justify-center text-blue-700 mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    <span class="font-medium">Kelas</span>
                  </div>
                  <div class="text-center">
                    <p class="text-2xl font-bold text-blue-800">{{ ketua.kelas }}</p>
                    <p class="text-sm text-gray-600 mt-1">Angkatan {{ getAngkatanFromKelas(ketua.kelas) }}</p>
                  </div>
                </div>

                <!-- Kolom Pengalaman -->
                <div class="bg-green-50 rounded-lg p-4">
                  <div class="flex items-center justify-center text-green-700 mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">Pengalaman</span>
                  </div>
                  <div class="text-center">
                    <div v-if="hasPengalaman(ketua)">
                      <p class="text-gray-700">{{ formatPengalaman(ketua.pengalaman_prestasi) }}</p>
                    </div>
                    <div v-else>
                      <p class="text-gray-500 italic">— Belum ada —</p>
                    </div>
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
            Total {{ anggotaTim.length }} anggota
          </p>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <div v-for="(anggota, idx) in anggotaTim" :key="anggota.id" 
                 class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition-shadow duration-300"
                 :data-aos="getAosAnimation(idx)" 
                 :data-aos-delay="(idx % 3) * 100 + 500">
              
              <div class="flex items-center gap-4">
                <!-- Inisial -->
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-lg font-bold flex-shrink-0">
                  {{ getInitials(anggota.nama) }}
                </div>
                
                <!-- Nama dan Posisi -->
                <div class="flex-1 min-w-0">
                  <h3 class="text-base font-semibold text-blue-600 truncate">{{ anggota.nama }}</h3>
                  <p class="text-sm text-gray-600 truncate">{{ anggota.posisi }}</p>
                </div>
              </div>

              <!-- Kelas dan Pengalaman -->
              <div class="mt-4 grid grid-cols-2 gap-3">
                <!-- Kelas -->
                <div class="bg-blue-50 rounded p-3">
                  <div class="flex items-center text-blue-700 mb-1">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                    </svg>
                    <span class="text-xs font-medium">Kelas</span>
                  </div>
                  <p class="text-sm font-semibold text-blue-800">{{ anggota.kelas }}</p>
                </div>

                <!-- Pengalaman -->
                <div class="bg-green-50 rounded p-3">
                  <div class="flex items-center text-green-700 mb-1">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-xs font-medium">Pengalaman</span>
                  </div>
                  <div v-if="hasPengalaman(anggota)">
                    <p class="text-xs text-gray-700 line-clamp-2">{{ formatPengalaman(anggota.pengalaman_prestasi) }}</p>
                  </div>
                  <div v-else>
                    <p class="text-xs text-gray-500 italic">—</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Informasi Bidang -->
        <div class="mt-16 bg-gradient-to-r from-blue-50 to-indigo-50 py-12 rounded-2xl">
          <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-light text-blue-600 mb-4" data-aos="fade-right" data-aos-delay="500">Tentang Bidang Ini</h2>
            <p class="text-gray-600 mb-8 max-w-3xl" data-aos="fade-left" data-aos-delay="500">
              {{ bidang.deskripsi }}
            </p>

            <div class="grid md:grid-cols-2 gap-8" data-aos="fade-up" data-aos-delay="500">
              <div v-for="(aktivitas, i) in getBidangActivities(bidang.id)" :key="i" 
                   class="flex items-start space-x-4 bg-white p-6 rounded-xl shadow-sm">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-pink-500 flex items-center justify-center text-white">
                  <span v-html="getIcon(aktivitas.icon)"></span>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-blue-600">{{ aktivitas.judul }}</h3>
                  <p class="text-gray-700 mt-2">{{ aktivitas.deskripsi }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <br/><br/>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const loading = ref(true)
const error = ref(null)
const bidang = ref({})
const semuaAnggota = ref([])

// Fetch data ketika route berubah
const fetchBidangData = async () => {
  loading.value = true
  error.value = null
  
  try {
    const bidangId = route.params.id
    
    console.log('Fetching data for bidang:', bidangId)
    
    // 1. Fetch bidang data berdasarkan ID
    const bidangResponse = await axios.get(`/bidang/${bidangId}`)
    bidang.value = bidangResponse.data.data
    console.log('Bidang data:', bidang.value)
    
    // 2. Fetch anggota yang memiliki bidang_id yang sesuai
    const anggotaResponse = await axios.get(`/anggota?bidang_id=${bidangId}`)
    semuaAnggota.value = anggotaResponse.data.data
    console.log(`Anggota untuk bidang ${bidangId}:`, semuaAnggota.value)
    console.log(`Jumlah anggota:`, semuaAnggota.value.length)
    
  } catch (err) {
    console.error('Error fetching data:', err)
    error.value = err.response?.data?.message || 'Gagal memuat data bidang'
    // Gunakan fallback data
    bidang.value = getFallbackData(route.params.id)
    semuaAnggota.value = []
  } finally {
    loading.value = false
  }
}

const getInitials = (nama) => {
  if (!nama) return '??'
  return nama
    .split(' ')
    .slice(0, 2)
    .map(n => n[0] || '')
    .join('')
    .toUpperCase()
}

// Helper function untuk mendapatkan angkatan dari kelas
const getAngkatanFromKelas = (kelas) => {
  if (!kelas) return ''
  const prefix = kelas.charAt(0)
  switch(prefix) {
    case 'X': return '2025' // Kelas X -> angkatan 2025
    case 'XI': return '2024' // Kelas XI -> angkatan 2024
    case 'XII': return '2023' // Kelas XII -> angkatan 2023
    default: return ''
  }
}

// Cek apakah anggota memiliki pengalaman
const hasPengalaman = (anggota) => {
  return anggota.pengalaman_prestasi && 
         anggota.pengalaman_prestasi.trim() !== '' && 
         anggota.pengalaman_prestasi !== '-' &&
         anggota.pengalaman_prestasi !== null
}

// Format pengalaman agar lebih rapi
const formatPengalaman = (pengalaman) => {
  if (!pengalaman || pengalaman === '-' || pengalaman === 'null') return ''
  // Jika pengalaman terlalu panjang, potong
  if (pengalaman.length > 100) {
    return pengalaman.substring(0, 100) + '...'
  }
  return pengalaman
}

// Animasi AOS berdasarkan index
const getAosAnimation = (index) => {
  const animations = ['fade-up', 'fade-left', 'fade-right']
  return animations[index % animations.length]
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
  return icons[name] || icons.sosial
}

// Fungsi untuk mendapatkan aktivitas berdasarkan bidang ID
const getBidangActivities = (bidangId) => {
  const activitiesByBidang = {
    1: [ // BPH
      { icon: "sosial", judul: "Rapat Koordinasi", deskripsi: "Mengadakan rapat rutin untuk koordinasi seluruh bidang OSIS." },
      { icon: "sosial", judul: "Administrasi", deskripsi: "Mengelola dokumen dan administrasi organisasi." }
    ],
    2: [ // Keamanan & Ketertiban
      { icon: "disiplin", judul: "Piket Harian", deskripsi: "Menjaga ketertiban di lingkungan sekolah setiap hari." },
      { icon: "disiplin", judul: "Pengamanan Acara", deskripsi: "Mengamankan kegiatan dan acara sekolah." }
    ],
    3: [ // Pramuka & Upacara
      { icon: "disiplin", judul: "Latihan PBB", deskripsi: "Melatih PBB untuk persiapan upacara bendera." },
      { icon: "sosial", judul: "Petugas Upacara", deskripsi: "Menyiapkan dan mengatur petugas upacara." }
    ],
    4: [ // Keagamaan
      { icon: "ibadah", judul: "Kultum Rutin", deskripsi: "Menyelenggarakan kultum setelah sholat dhuha." },
      { icon: "ibadah", judul: "Kegiatan PHBI", deskripsi: "Mengorganisir peringatan hari besar Islam." }
    ],
    5: [ // Kesehatan
      { icon: "sosial", judul: "Piket UKS", deskripsi: "Bertugas di UKS untuk membantu siswa yang sakit." },
      { icon: "sosial", judul: "Edukasi Kesehatan", deskripsi: "Menyelenggarakan penyuluhan tentang kesehatan." }
    ],
    6: [ // Seni & Humas
      { icon: "seni", judul: "Dokumentasi", deskripsi: "Mendokumentasikan seluruh kegiatan sekolah." },
      { icon: "publikasi", judul: "Media Sosial", deskripsi: "Mengelola akun media sosial OSIS." }
    ],
    7: [ // Olahraga
      { icon: "sosial", judul: "Latihan Tim", deskripsi: "Melatih tim ekstrakurikuler olahraga." },
      { icon: "lomba", judul: "Turnamen", deskripsi: "Menyelenggarakan turnamen olahraga antar kelas." }
    ]
  }
  
  return activitiesByBidang[bidangId] || activitiesByBidang[1]
}

// Computed properties untuk mengelompokkan anggota
const koordinator = computed(() => {
  // Filter berdasarkan posisi yang mengandung "Ketua" (kecuali Ketua Departemen)
  return semuaAnggota.value.filter(anggota => {
    const posisi = anggota.posisi?.toLowerCase() || ''
    return posisi.includes('ketua') && !posisi.includes('departemen')
  })
})

const ketuaDepartemen = computed(() => {
  // Filter yang memiliki "Ketua Departemen" di posisi
  return semuaAnggota.value.filter(anggota => {
    const posisi = anggota.posisi?.toLowerCase() || ''
    return posisi.includes('departemen')
  })
})

const anggotaTim = computed(() => {
  // Filter anggota biasa (bukan ketua/koordinator/ketua departemen)
  return semuaAnggota.value.filter(anggota => {
    const posisi = anggota.posisi?.toLowerCase() || ''
    return !posisi.includes('ketua') && 
           !posisi.includes('departemen') &&
           !posisi.includes('sekretaris') &&
           !posisi.includes('bendahara')
  })
})

// Fallback data jika API error
const getFallbackData = (id) => {
  const fallbackData = {
    1: {
      id: 1,
      nama: "Badan Pengurus Harian (BPH)",
      deskripsi: "BPH menjalankan fungsi koordinasi, administrasi, dan kepemimpinan organisasi OSIS.",
      tugas_umum: "Mengkoordinasikan seluruh bidang OSIS"
    },
    2: {
      id: 2,
      nama: "Bidang Keamanan & Ketertiban",
      deskripsi: "Bidang Keamanan memastikan seluruh kegiatan sekolah berjalan tertib dan aman.",
      tugas_umum: "Menjaga ketertiban saat kegiatan sekolah"
    },
    3: {
      id: 3,
      nama: "Bidang Pramuka & Upacara",
      deskripsi: "Bidang ini aktif dalam kegiatan pramuka, PBB, dan persiapan upacara sekolah.",
      tugas_umum: "Mengorganisir petugas upacara"
    },
    4: {
      id: 4,
      nama: "Bidang Keagamaan",
      deskripsi: "Bidang Keagamaan mengisi kegiatan rohani dan pembinaan akhlak di sekolah.",
      tugas_umum: "Mengadakan kegiatan keagamaan rutin"
    },
    5: {
      id: 5,
      nama: "Bidang Kesehatan",
      deskripsi: "Bidang Kesehatan bertanggung jawab menjaga kesehatan siswa dan mengadakan kegiatan edukasi kesehatan.",
      tugas_umum: "Memonitor kondisi kesehatan siswa"
    },
    6: {
      id: 6,
      nama: "Bidang Seni & Humas",
      deskripsi: "Bidang Seni & Humas bertugas mengelola komunikasi, dokumentasi, dan promosi kegiatan OSIS.",
      tugas_umum: "Mengelola dokumentasi kegiatan sekolah"
    },
    7: {
      id: 7,
      nama: "Bidang Olahraga",
      deskripsi: "Bidang Olahraga memfasilitasi kegiatan fisik, pelatihan tim, dan lomba olahraga di sekolah.",
      tugas_umum: "Mengorganisir kegiatan olahraga sekolah"
    }
  }
  
  return fallbackData[id] || fallbackData[1]
}

// Fetch data ketika komponen dimount
onMounted(() => {
  fetchBidangData()
})

// Fetch data ulang ketika route berubah
watch(() => route.params.id, () => {
  fetchBidangData()
})
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>