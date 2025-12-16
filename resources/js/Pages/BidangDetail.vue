<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Loading State -->
    <div v-if="loading" class="text-center py-20">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
      <p class="mt-4 text-gray-600">Memuat data bidang...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-6 text-center mx-4 my-8">
      <div class="text-red-600 mb-2">
        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <h3 class="text-lg font-medium text-red-800 mb-2">Gagal memuat data bidang</h3>
      <p class="text-red-700 mb-4">{{ error }}</p>
      <button
        @click="fetchBidangData"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg mr-2"
      >
        Coba Lagi
      </button>
      <button
        @click="$router.back()"
        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg"
      >
        Kembali
      </button>
    </div>

    <!-- Content -->
    <div v-else class="max-w-7xl mx-auto px-4 py-8">
      <!-- Header dengan tombol kembali -->
      <div class="mb-6 pt-10">
        <button
          @click="router.back()"
          class="flex items-center text-blue-600 hover:text-blue-800 mb-4 px-4 py-2 rounded-lg border border-blue-600 hover:bg-blue-50 transition"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Kembali
        </button>
      </div>

      <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <!-- Gambar bidang di tengah -->
        <div class="flex justify-center items-center py-8 px-4">
          <div class="relative w-[800px] h-[400px]"> <!-- Ukuran diperbesar -->
            <img
              :src="getImageUrl(bidang.img)"
              :alt="bidang.nama"
              class="w-full h-full object-contain"
              @error="handleImageError"
            />
          </div>
        </div>
        
        <!-- Nama bidang di bawah gambar -->
        <div class="text-center pb-6">
          <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ bidang.nama }}</h1>
        </div>
        
        <!-- Detail Bidang -->
        <div class="p-6 md:p-8">
          <!-- Deskripsi -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Deskripsi Bidang</h2>
            <p class="text-gray-700 leading-relaxed text-justify">{{ bidang.deskripsi || 'Tidak ada deskripsi.' }}</p>
          </div>

          <!-- Tugas Umum -->
          <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Tugas Umum</h2>
            <p class="text-gray-700 text-justify">{{ bidang.tugas_umum || 'Tidak ada tugas umum yang dijelaskan.' }}</p>
          </div>
        </div>
      </div>

      <!-- Daftar Anggota -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-2xl font-bold text-gray-900">Anggota Bidang</h2>
              <p class="text-gray-600 mt-1">Daftar anggota yang tergabung dalam {{ bidang.nama }}</p>
            </div>
            <!-- Hapus tombol toggle grid/table -->
          </div>
        </div>

        <!-- Loading Anggota -->
        <div v-if="loadingAnggota" class="text-center py-12">
          <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-600"></div>
          <p class="mt-3 text-gray-600">Memuat daftar anggota...</p>
        </div>

        <!-- Empty State -->
        <div v-else-if="anggotaBidang.length === 0" class="text-center py-12">
          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada anggota</h3>
          <p class="text-gray-600">Tidak ada anggota yang tergabung dalam bidang ini.</p>
        </div>

        <!-- Grid View Only -->
        <div v-else class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div
              v-for="anggota in anggotaBidang"
              :key="anggota.id"
              class="bg-gray-50 rounded-lg shadow overflow-hidden hover:shadow-md transition transform hover:-translate-y-1"
            >
              <!-- Header with Image -->
              <div class="relative h-48 overflow-hidden">
                <img
                  :src="getImageUrl(anggota.img)"
                  :alt="anggota.nama"
                  class="w-full h-full object-cover"
                />
                <!-- Hapus Status Badge dari sini -->
              </div>
              
              <!-- Content -->
              <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-1 text-center">{{ anggota.nama }}</h3>
                <p class="text-blue-600 font-medium text-sm mb-2 text-center">{{ anggota.posisi }}</p>
                
                <!-- Quote -->
                <div class="mb-3">
                  <p class="text-gray-600 text-sm italic text-center">"{{ truncateText(anggota.quote, 60) }}"</p>
                </div>
                
                <!-- Masa Bakti -->
                <div class="mb-3">
                  <p class="text-xs text-gray-500 text-center">Masa Bakti</p>
                  <p class="text-sm font-medium text-gray-800 text-center">{{ anggota.masa_bakti }}</p>
                </div>
                
                <!-- Hapus Action Button/Lihat Detail -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

// State
const bidang = ref({})
const bidangs = ref([])
const anggotaList = ref([])
const loading = ref(true)
const loadingAnggota = ref(true)
const error = ref(null)

// Hapus displayMode karena hanya menggunakan grid view

// Computed
const anggotaBidang = computed(() => {
  if (!bidang.value.id) return []
  return anggotaList.value.filter(anggota => 
    anggota.bidang_id == bidang.value.id && anggota.status === 'aktif'
  )
})

// Methods
const getImageUrl = (imgPath) => {
  try {
    if (!imgPath || imgPath.trim() === '') {
      return 'https://via.placeholder.com/400x300?text=No+Image';
    }
    
    if (imgPath.startsWith('http://') || imgPath.startsWith('https://')) {
      return imgPath;
    }
    
    let normalizedPath = imgPath;
    
    if (normalizedPath.startsWith('public/')) {
      normalizedPath = normalizedPath.substring(7);
    }
    
    if (normalizedPath.startsWith('/')) {
      normalizedPath = normalizedPath.substring(1);
    }
    
    if (normalizedPath.includes('bidangs/')) {
      if (!normalizedPath.startsWith('storage/')) {
        return `/storage/${normalizedPath}`;
      }
      return `/${normalizedPath}`;
    }
    
    return `/storage/bidangs/${normalizedPath}`;
  } catch (error) {
    console.error('Error generating image URL:', error);
    return 'https://via.placeholder.com/400x300?text=Error+Loading';
  }
}

const handleImageError = (e) => {
  e.target.src = 'https://via.placeholder.com/400x300?text=No+Image'
}

const truncateText = (text, length) => {
  if (!text) return ''
  return text.length > length ? text.substring(0, length) + '...' : text
}

const getAnggotaCountByStatus = (status) => {
  return anggotaBidang.value.filter(a => a.status === status).length
}

// Fetch data
const fetchBidangData = async () => {
  loading.value = true
  error.value = null
  
  try {
    // Hapus token karena ini untuk user view (tidak perlu auth)
    // Fetch specific bidang
    const bidangResponse = await axios.get(`/bidang/${route.params.id}`)
    bidang.value = bidangResponse.data.data || bidangResponse.data
    
    // Fetch all bidangs (untuk konteks saja)
    const bidangsResponse = await axios.get('/bidang')
    bidangs.value = bidangsResponse.data.data || bidangsResponse.data
    
    // Fetch all anggota
    loadingAnggota.value = true
    const anggotaResponse = await axios.get('/anggota')
    anggotaList.value = anggotaResponse.data.data || anggotaResponse.data
    
  } catch (err) {
    console.error('Error fetching data:', err)
    error.value = err.response?.data?.message || 'Gagal memuat data bidang.'
  } finally {
    loading.value = false
    loadingAnggota.value = false
  }
}

// Lifecycle
onMounted(() => {
  fetchBidangData()
})
</script>

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>