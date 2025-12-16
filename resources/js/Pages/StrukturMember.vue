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
        <button @click="fetchData" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          Coba Lagi
        </button>
      </div>
  
      <!-- Content -->
      <div v-else>
        <div class="max-w-7xl mx-auto px-4 py-12">
          <!-- Header -->
          <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-light text-blue-600 mb-4">Daftar Anggota OSIS</h1>
            <div class="w-16 h-0.5 bg-osisGold mx-auto"></div>
            <p class="text-gray-600 mt-4">Masa Bakti 2025/2026</p>
          </div>
 
          <!-- Filter Controls -->
          <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Anggota</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <!-- Search -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                  </div>
                  <input
                    v-model="filters.search"
                    type="text"
                    placeholder="Cari nama anggota..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
 
              <!-- Filter Bidang -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bidang</label>
                <select
                  v-model="filters.bidang"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">Semua Bidang</option>
                  <option v-for="bidang in uniqueBidangs" :key="bidang" :value="bidang">
                    {{ bidang }}
                  </option>
                </select>
              </div>
 
              <!-- Filter Posisi -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Posisi</label>
                <select
                  v-model="filters.posisi"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">Semua Posisi</option>
                  <option v-for="posisi in posisiOptions" :key="posisi" :value="posisi">
                    {{ posisi }}
                  </option>
                </select>
              </div>
            </div>
 
            <!-- Active Filters -->
            <div v-if="hasActiveFilters" class="mt-4 flex flex-wrap gap-2 items-center">
              <span class="text-sm text-gray-600">Filter aktif:</span>
              
              <span 
                v-if="filters.search" 
                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800"
              >
                Pencarian: "{{ filters.search }}"
                <button @click="filters.search = ''" class="ml-1 text-green-600 hover:text-green-800">
                  &times;
                </button>
              </span>
              
              <span 
                v-if="filters.bidang" 
                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800"
              >
                Bidang: {{ filters.bidang }}
                <button @click="filters.bidang = ''" class="ml-1 text-blue-600 hover:text-blue-800">
                  &times;
                </button>
              </span>
              
              <span 
                v-if="filters.posisi" 
                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800"
              >
                Posisi: {{ filters.posisi }}
                <button @click="filters.posisi = ''" class="ml-1 text-purple-600 hover:text-purple-800">
                  &times;
                </button>
              </span>
              
              <button 
                @click="resetFilters"
                class="text-sm text-red-600 hover:text-red-800 ml-2"
              >
                Reset semua filter
              </button>
            </div>
          </div>
  
          <!-- Results Info -->
          <div v-if="filteredMembers.length === 0" class="text-center py-12 bg-gray-50 rounded-xl">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ditemukan anggota</h3>
            <p class="text-gray-600 mb-4">Coba ubah filter atau kata pencarian Anda.</p>
            <button 
              @click="resetFilters"
              class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
              Reset Filter
            </button>
          </div>
  
          <!-- Members Grid -->
          <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
              <div
                  v-for="member in filteredMembers"
                  :key="member.id"
                  class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col"
                  data-aos="fade-up"
                  data-aos-delay="200"
              >
                  <!-- Foto/Inisial dan Info Utama -->
                  <div class="flex items-center gap-4 mb-4">
                      <!-- Inisial -->
                      <div 
                        :class="[
                          'w-16 h-16 rounded-full flex items-center justify-center text-white text-xl font-bold flex-shrink-0',
                          getPositionColor(member.posisi)
                        ]"
                      >
                          {{ getInitials(member.nama) }}
                      </div>
                      <div class="flex-1 min-w-0">
                          <h3 class="text-lg font-semibold text-blue-600 truncate">{{ member.nama }}</h3>
                          <p class="text-sm text-gray-600 truncate">{{ member.posisi }}</p>
                          <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800 mt-1 inline-block">
                            {{ member.bidang?.nama }}
                          </span>
                      </div>
                  </div>
  
                  <!-- Detail Info -->
                  <div class="space-y-3 mt-auto">
                      <!-- Bidang -->
                      <div class="bg-blue-50 rounded-lg p-3">
                          <div class="flex items-center text-blue-700 mb-1">
                              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                              </svg>
                              <span class="text-xs font-medium">Bidang</span>
                          </div>
                          <p class="text-sm font-semibold text-blue-800 truncate">{{ member.bidang?.nama}}</p>
                      </div>
  
                      <!-- Kelas -->
                      <div class="bg-indigo-50 rounded-lg p-3">
                          <div class="flex items-center text-indigo-700 mb-1">
                              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                              </svg>
                              <span class="text-xs font-medium">Kelas</span>
                          </div>
                          <p class="text-sm font-semibold text-indigo-800">{{ member.kelas }}</p>
                          <p class="text-xs text-gray-600">Angkatan {{ getAngkatanFromKelas(member.kelas) }}</p>
                      </div>
  
                      <!-- Pengalaman -->
                      <div class="bg-green-50 rounded-lg p-3">
                          <div class="flex items-center text-green-700 mb-1">
                              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                              </svg>
                              <span class="text-xs font-medium">Pengalaman</span>
                          </div>
                          <div v-if="hasPengalaman(member)">
                              <p class="text-xs text-gray-700 line-clamp-2">{{ formatPengalaman(member.pengalaman_prestasi) }}</p>
                          </div>
                          <div v-else>
                              <p class="text-xs text-gray-500 italic">— Tidak Ada —</p>
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
  import { ref, onMounted, computed } from 'vue'
  import axios from 'axios'
  
  const loading = ref(true)
  const error = ref(null)
  const allMembers = ref([])
  
  // Filters
  const filters = ref({
    search: '',
    bidang: '',
    posisi: ''
  })
  
  // Posisi options sesuai permintaan
  const posisiOptions = [
    'Ketua Umum',
    'Ketua',
    'Sekretaris Umum',
    'Sekretaris',
    'Bendahara Umum',
    'Bendahara',
    'Ketua Departemen',
    'Anggota'
  ]
  
  // Fetch data
  const fetchData = async () => {
      loading.value = true
      error.value = null
  
      try {
          // Ambil semua anggota dan data bidangnya sekaligus melalui relasi
          const response = await axios.get('/anggota?with_bidang=true')
          allMembers.value = response.data.data
          console.log('All members data:', allMembers.value)
      } catch (err) {
          console.error('Error fetching members:', err)
          error.value = err.response?.data?.message || 'Gagal memuat data anggota.'
          allMembers.value = []
      } finally {
          loading.value = false
      }
  }
  
  // Computed properties
  const uniqueBidangs = computed(() => {
    const bidangs = allMembers.value
      .map(member => member.bidang?.nama)
      .filter((nama, index, self) => nama && self.indexOf(nama) === index)
      .sort()
    return [ ...bidangs.filter(b => b !== 'Umum')]
  })
  
  const uniquePosisis = computed(() => {
    const posisis = allMembers.value
      .map(member => member.posisi)
      .filter((posisi, index, self) => posisi && self.indexOf(posisi) === index)
      .sort()
    return posisis
  })
  
  const filteredMembers = computed(() => {
    return allMembers.value.filter(member => {
      const bidangNama = member.bidang?.nama
      
      // Filter by search
      if (filters.value.search) {
        const searchLower = filters.value.search.toLowerCase()
        const matchesSearch = 
          member.nama.toLowerCase().includes(searchLower) ||
          member.posisi.toLowerCase().includes(searchLower) ||
          bidangNama.toLowerCase().includes(searchLower) ||
          (member.pengalaman_prestasi && member.pengalaman_prestasi.toLowerCase().includes(searchLower))
        
        if (!matchesSearch) return false
      }
      
      // Filter by bidang
      if (filters.value.bidang) {
        if (bidangNama !== filters.value.bidang) return false
      }
      
      // Filter by posisi
      if (filters.value.posisi) {
        if (member.posisi !== filters.value.posisi) return false
      }
      
      return true
    })
  })
  
  const hasActiveFilters = computed(() => {
    return filters.value.search || filters.value.bidang || filters.value.posisi
  })
  
  // Helper functions
  const getInitials = (nama) => {
      if (!nama) return '??'
      return nama
          .split(' ')
          .slice(0, 2)
          .map(n => n[0] || '')
          .join('')
          .toUpperCase()
  }
  
  const getAngkatanFromKelas = (kelas) => {
      if (!kelas) return ''
      const prefix = kelas.charAt(0)
      switch(prefix) {
          case 'X': return '2025'
          case 'XI': return '2024'
          case 'XII': return '2023'
          default: return ''
      }
  }
  
  const hasPengalaman = (member) => {
      return member.pengalaman_prestasi && 
             member.pengalaman_prestasi.trim() !== '' && 
             member.pengalaman_prestasi !== '-' &&
             member.pengalaman_prestasi !== null
  }
  
  const formatPengalaman = (pengalaman) => {
      if (!pengalaman || pengalaman === '-' || pengalaman === 'null') return ''
      if (pengalaman.length > 100) {
          return pengalaman.substring(0, 100) + '...'
      }
      return pengalaman
  }
  
  const getPositionColor = (posisi) => {
    const colorMap = {
      'Ketua Umum': 'bg-red-600',
      'Ketua': 'bg-red-500',
      'Sekretaris Umum': 'bg-green-600',
      'Sekretaris': 'bg-green-500',
      'Bendahara Umum': 'bg-yellow-600',
      'Bendahara': 'bg-yellow-500',
      'Ketua Departemen': 'bg-purple-600',
      'Anggota': 'bg-blue-600'
    }
    return colorMap[posisi] || 'bg-blue-600'
  }
  
  const resetFilters = () => {
    filters.value = {
      search: '',
      bidang: '',
      posisi: ''
    }
  }
  
  onMounted(() => {
      fetchData()
  })
  </script>
  
  <style scoped>
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
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