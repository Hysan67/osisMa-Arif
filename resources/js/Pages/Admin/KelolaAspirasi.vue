<template>
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Aspirasi</h1>
      <p class="text-gray-600">Kelola aspirasi yang masuk dari pengunjung</p>
    </div>
 
     <!-- Stats Cards -->
     <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
       <div class="bg-white rounded-lg shadow p-4">
         <div class="flex items-center justify-between">
           <div>
             <p class="text-sm text-gray-600">Total Aspirasi</p>
             <p class="text-2xl font-bold text-gray-800">{{ stats.total || 0 }}</p>
           </div>
           <div class="p-3 bg-blue-100 rounded-full">
             <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
             </svg>
           </div>
         </div>
       </div>
       
       <div class="bg-white rounded-lg shadow p-4">
         <div class="flex items-center justify-between">
           <div>
             <p class="text-sm text-gray-600">Menunggu</p>
             <p class="text-2xl font-bold text-yellow-600">{{ stats.menunggu || 0 }}</p>
           </div>
           <div class="p-3 bg-yellow-100 rounded-full">
             <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
             </svg>
           </div>
         </div>
       </div>
       
       <div class="bg-white rounded-lg shadow p-4">
         <div class="flex items-center justify-between">
           <div>
             <p class="text-sm text-gray-600">Sudah Dibalas</p>
             <p class="text-2xl font-bold text-green-600">{{ stats.dibalas || 0 }}</p>
           </div>
           <div class="p-3 bg-green-100 rounded-full">
             <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
             </svg>
           </div>
         </div>
       </div>
       
       <div class="bg-white rounded-lg shadow p-4">
         <div class="flex items-center justify-between">
           <div>
             <p class="text-sm text-gray-600">Ditolak</p>
             <p class="text-2xl font-bold text-red-600">{{ stats.ditolak || 0 }}</p>
           </div>
           <div class="p-3 bg-red-100 rounded-full">
             <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
             </svg>
           </div>
         </div>
       </div>
     </div>
 
     <!-- Filters -->
     <div class="bg-white rounded-lg shadow p-4 mb-6">
       <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
         <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
           <select v-model="filters.status" @change="applyFilters" class="w-full rounded-lg border border-gray-300 px-3 py-2">
             <option value="">Semua Status</option>
             <option value="menunggu">Menunggu</option>
             <option value="dibalas">Sudah Dibalas</option>
             <option value="ditolak">Ditolak</option>
           </select>
         </div>
         
         <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
           <input v-model="filters.start_date" type="date" @change="applyFilters" class="w-full rounded-lg border border-gray-300 px-3 py-2">
         </div>
         
         <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
           <input v-model="filters.end_date" type="date" @change="applyFilters" class="w-full rounded-lg border border-gray-300 px-3 py-2">
         </div>
         
         <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
           <div class="flex">
             <input v-model="filters.search" type="text" placeholder="Cari nama/judul..." 
                    class="flex-1 rounded-l-lg border border-gray-300 px-3 py-2">
             <button @click="applyFilters" class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
               </svg>
             </button>
           </div>
         </div>
       </div>
 
       <!-- Bulk Actions -->
     <div class="bg-white rounded-lg shadow p-4 mb-6">
       <div class="flex items-center space-x-3">
         <input type="checkbox" v-model="selectAll" @change="toggleSelectAll" class="rounded border-gray-300">
         <span class="text-sm text-gray-600">Pilih Semua</span>
         
         <select v-model="bulkAction" class="rounded-lg border border-gray-300 px-3 py-1 text-sm">
           <option value="">Aksi Massal</option>
           <option value="dibalas">Tandai sebagai Dibalas</option>
           <option value="ditolak">Tandai sebagai Ditolak</option>
           <option value="menunggu">Tandai sebagai Menunggu</option>
           <option value="delete">Hapus</option>
         </select>
         
         <button @click="applyBulkAction" 
                 :disabled="!bulkAction || selectedAspirasi.length === 0"
                 class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
           Terapkan
         </button>
       </div>
       </div>
     </div>
 
     <!-- Loading State -->
     <div v-if="loading" class="text-center py-12">
       <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
       <p class="mt-4 text-gray-600">Memuat data aspirasi...</p>
     </div>
 
     <!-- Empty State -->
     <div v-else-if="aspirasiData.length === 0" class="bg-white rounded-lg shadow p-8 text-center">
       <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
       </svg>
       <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada aspirasi</h3>
       <p class="text-gray-600">Belum ada aspirasi yang masuk dari pengunjung</p>
     </div>
 
     <!-- Aspirasi List -->
     <div v-else class="space-y-4">
       <div v-for="aspirasi in aspirasiData" :key="aspirasi.id" 
            class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition"
            :class="{'border-l-4': true, 
                    'border-yellow-400': aspirasi.status === 'menunggu',
                    'border-green-400': aspirasi.status === 'dibalas',
                    'border-red-400': aspirasi.status === 'ditolak'}">
         
         <!-- Aspirasi Header -->
         <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
           <div class="flex items-center space-x-3">
             <input type="checkbox" :value="aspirasi.id" v-model="selectedAspirasi" class="rounded border-gray-300">
             
             <div>
               <h3 class="font-semibold text-gray-800">{{ aspirasi.judul }}</h3>
               <p class="text-sm text-gray-600">
                 <span class="font-medium">{{ aspirasi.nama }}</span>
                 <span v-if="aspirasi.kelas"> • {{ aspirasi.kelas }}</span>
               </p>
             </div>
           </div>
           
           <div class="flex items-center space-x-3">
             <span class="px-3 py-1 text-xs font-semibold rounded-full"
                   :class="getStatusClass(aspirasi.status)">
               {{ aspirasi.status_label }}
             </span>
             
             <span class="text-sm text-gray-500">
               {{ aspirasi.created_at_formatted }}
             </span>
             
             <div class="flex space-x-1">
               <button @click="updateStatus(aspirasi, 'dibalas')" 
                       v-if="aspirasi.status !== 'dibalas'"
                       class="p-1 text-green-600 hover:text-green-800 hover:bg-green-50 rounded"
                       title="Tandai Dibalas">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                 </svg>
               </button>
               
               <button @click="updateStatus(aspirasi, 'ditolak')" 
                       v-if="aspirasi.status !== 'ditolak'"
                       class="p-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded"
                       title="Tandai Ditolak">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                 </svg>
               </button>
               
               <button @click="updateStatus(aspirasi, 'menunggu')" 
                       v-if="aspirasi.status !== 'menunggu'"
                       class="p-1 text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 rounded"
                       title="Tandai Menunggu">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                 </svg>
               </button>
               
               <button @click="confirmDelete(aspirasi)" 
                       class="p-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                 </svg>
               </button>
             </div>
           </div>
         </div>
         
         <!-- Aspirasi Content -->
         <div class="px-6 py-4">
           <div class="mb-2">
             <span class="font-medium text-gray-700">Email:</span>
             <span class="text-gray-600 ml-2">{{ aspirasi.email }}</span>
           </div>
           
           <p class="text-gray-700 whitespace-pre-line">{{ aspirasi.pesan }}</p>
         </div>
       </div>
     </div>

     <!-- Pagination -->

     <!-- Alert -->
     <transition name="fade-slide">
       <div v-if="alert.show" 
            class="fixed bottom-6 right-6 px-6 py-4 rounded-lg shadow-lg text-white z-50 flex items-center"
            :class="alert.color">
         <svg v-if="alert.type === 'success'" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
         </svg>
         <svg v-else class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
         </svg>
         {{ alert.message }}
       </div>
     </transition>
   </div>
</template>
 
<script setup>
  import { ref, computed, onMounted, watch } from 'vue'
  import axios from 'axios'
  
  const loading = ref(false)
  const aspirasiData = ref([])
  const selectedAspirasi = ref([])
  const selectAll = ref(false)
  const bulkAction = ref('')
  const stats = ref({})
  
  const pagination = ref({
    current_page: 1,
    last_page: 1,
    per_page: 20,
    total: 0
  })
  
  const filters = ref({
    status: '',
    start_date: '',
    end_date: '',
    search: ''
  })
  
  const alert = ref({
    show: false,
    type: 'success',
    message: '',
    color: 'bg-green-500'
  })
  
  // Methods
  function showAlert(message, type = 'success') {
    alert.value = {
      show: true,
      message,
      type,
      color: type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }
    setTimeout(() => {
      alert.value.show = false
    }, 3000)
  }
  
  function getStatusClass(status) {
    const classes = {
      menunggu: 'bg-yellow-100 text-yellow-800',
      dibalas: 'bg-green-100 text-green-800',
      ditolak: 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
  }
  
  async function fetchAspirasi() {
    loading.value = true
    try {
      const token = localStorage.getItem('token')
      
      if (!token) {
        showAlert('Token tidak ditemukan. Silakan login ulang.', 'error')
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        setTimeout(() => {
          window.location.href = '/login'
        }, 1500)
        return
      }
      
      const params = {
        page: pagination.value.current_page,
        per_page: pagination.value.per_page,
        ...filters.value
      }
      
      // Clean params
      Object.keys(params).forEach(key => {
        if (params[key] === '' || params[key] === null || params[key] === undefined) {
          delete params[key]
        }
      })
      
      const baseUrl = import.meta.env.VITE_API_URL || window.location.origin
      
      const url = new URL('/api/admin/aspirasi', baseUrl)
      Object.keys(params).forEach(key => {
        url.searchParams.append(key, params[key])
      })
      
      const response = await fetch(url.toString(), {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        }
      })
      
      if (!response.ok) {
        const errorText = await response.text()
        console.error('Error response text:', errorText)
        throw new Error(`HTTP error! status: ${response.status}`)
      }
      
      const data = await response.json()
      
      aspirasiData.value = data.data || []
      pagination.value = data.meta || {
        current_page: 1,
        last_page: 1,
        per_page: 20,
        total: 0
      }
      stats.value = data.stats || {}
      
    } catch (error) {
      console.error('Error details:', error)
      showAlert(`Gagal memuat data: ${error.message}`, 'error')
      
      if (error.message.includes('401') || error.message.includes('Unauthorized')) {
        setTimeout(() => {
          localStorage.removeItem('token')
          localStorage.removeItem('user')
          window.location.href = '/login'
        }, 2000)
      }
    } finally {
      loading.value = false
    }
  }
  
  function applyFilters() {
    pagination.value.current_page = 1
    fetchAspirasi()
  }
  
  function toggleSelectAll() {
    if (selectAll.value) {
      selectedAspirasi.value = aspirasiData.value.map(a => a.id)
    } else {
      selectedAspirasi.value = []
    }
  }
  
  async function applyBulkAction() {
    if (!bulkAction.value || selectedAspirasi.value.length === 0) return
    
    if (bulkAction.value === 'delete') {
      if (!confirm(`Hapus ${selectedAspirasi.value.length} aspirasi?`)) return
    } else {
      if (!confirm(`Update status ${selectedAspirasi.value.length} aspirasi menjadi "${bulkAction.value}"?`)) return
    }
    
    try {
      const token = localStorage.getItem('token')
      
      if (bulkAction.value === 'delete') {
        // Delete multiple
        for (const id of selectedAspirasi.value) {
          await axios.delete(`/api/admin/aspirasi/${id}`, {
            headers: { 'Authorization': `Bearer ${token}` }
          })
        }
        showAlert(`${selectedAspirasi.value.length} aspirasi berhasil dihapus`)
      } else {
        // Update status
        await axios.post('/api/admin/aspirasi/bulk-update', {
          aspirasi_ids: selectedAspirasi.value,
          status: bulkAction.value
        }, {
          headers: { 'Authorization': `Bearer ${token}` }
        })
        
        showAlert(`Status ${selectedAspirasi.value.length} aspirasi diperbarui menjadi "${bulkAction.value}"`)
      }
      
      selectedAspirasi.value = []
      selectAll.value = false
      bulkAction.value = ''
      fetchAspirasi()
      
    } catch (error) {
      console.error('Bulk action error:', error)
      showAlert('Gagal melakukan aksi massal', 'error')
    }
  }
  
  async function updateStatus(aspirasi, newStatus) {
    if (!confirm(`Ubah status aspirasi menjadi "${newStatus}"?`)) return
    
    try {
      const token = localStorage.getItem('token')
      const response = await axios.post(`/api/admin/aspirasi/${aspirasi.id}/update-status`, {
        status: newStatus
      }, {
        headers: { 'Authorization': `Bearer ${token}` }
      })
      
      if (response.data.success) {
        showAlert('Status aspirasi berhasil diperbarui')
        fetchAspirasi()
      }
    } catch (error) {
      showAlert('Gagal memperbarui status', 'error')
    }
  }
  
  async function confirmDelete(aspirasi) {
    if (!confirm(`Hapus aspirasi dari ${aspirasi.nama}?`)) return
    
    try {
      const token = localStorage.getItem('token')
      await axios.delete(`/api/admin/aspirasi/${aspirasi.id}`, {
        headers: { 'Authorization': `Bearer ${token}` }
      })
      
      showAlert('Aspirasi berhasil dihapus')
      fetchAspirasi()
    } catch (error) {
      showAlert('Gagal menghapus aspirasi', 'error')
    }
  }
  
  // Pagination
  function prevPage() {
    if (pagination.value.current_page > 1) {
      pagination.value.current_page--
      fetchAspirasi()
    }
  }
  
  function nextPage() {
    if (pagination.value.current_page < pagination.value.last_page) {
      pagination.value.current_page++
      fetchAspirasi()
    }
  }
  
  // Watchers
  watch(selectedAspirasi, (newVal) => {
    selectAll.value = newVal.length === aspirasiData.value.length && aspirasiData.value.length > 0
  })
  
  // Lifecycle
  onMounted(() => {
    fetchAspirasi()
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
   from { transform: rotate(0deg); }
   to { transform: rotate(360deg); }
 }
 
 .fade-slide-enter-active,
 .fade-slide-leave-active {
   transition: all 0.3s ease;
 }
 .fade-slide-enter-from,
 .fade-slide-leave-to {
   opacity: 0;
   transform: translateY(10px);
 }
 </style>