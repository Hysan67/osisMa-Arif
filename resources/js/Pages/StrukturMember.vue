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
 
         <!-- Stats -->
         <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-12 text-center">
             <p class="text-xl font-medium text-blue-700">
                 Total Anggota Terdaftar: <span class="font-bold">{{ allMembers.length }}</span>
             </p>
         </div>
 
         <!-- Members Grid -->
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
             <div
                 v-for="member in allMembers"
                 :key="member.id"
                 class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col"
                 data-aos="fade-up"
                 data-aos-delay="200"
             >
                 <!-- Foto/Inisial dan Info Utama -->
                 <div class="flex items-center gap-4 mb-4">
                     <!-- Inisial -->
                     <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl font-bold flex-shrink-0">
                         {{ getInitials(member.nama) }}
                     </div>
                     <div class="flex-1 min-w-0">
                         <h3 class="text-lg font-semibold text-blue-600 truncate">{{ member.nama }}</h3>
                         <p class="text-sm text-gray-600 truncate">{{ member.posisi }}</p>
                     </div>
                 </div>
 
                 <!-- Detail Info -->
                 <div class="space-y-3 mt-auto">
                     <!-- Bidang -->
                     <div class="bg-blue-50 rounded-lg p-3">
                         <div class="flex items-center text-blue-700 mb-1">
                             <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                 <path fill-rule="evenodd" d="M17.778 8.222c-4.296-4.296-11.26-4.296-15.556 0A1 1 0 01.808 6.808c5.076-5.077 13.308-5.077 18.384 0a1 1 0 01-1.414 1.414zM14.95 11.05a7 7 0 00-9.9 0 1 1 0 01-1.414-1.414 9 9 0 0112.728 0 1 1 0 01-1.414 1.414zM12.12 13.88a3 3 0 00-4.242 0 1 1 0 01-1.415-1.415 5 5 0 017.072 0 1 1 0 01-1.415 1.415zM9 16a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                             </svg>
                             <span class="text-xs font-medium">Bidang</span>
                         </div>
                         <p class="text-sm font-semibold text-blue-800 truncate">{{ member.bidang.nama }}</p>
                     </div>
 
                     <!-- Kelas -->
                     <div class="bg-indigo-50 rounded-lg p-3">
                         <div class="flex items-center text-indigo-700 mb-1">
                             <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                 <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                             </svg>
                             <span class="text-xs font-medium">Kelas</span>
                         </div>
                         <p class="text-sm font-semibold text-indigo-800">{{ member.kelas }}</p>
                         <p class="text-xs text-gray-600">Angkatan {{ getAngkatanFromKelas(member.kelas) }}</p>
                     </div>
 
                     <!-- Pengalaman -->
                     <div class="bg-green-50 rounded-lg p-3">
                         <div class="flex items-center text-green-700 mb-1">
                             <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                 <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
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
 import { ref, onMounted } from 'vue'
 import axios from 'axios'
 
 const loading = ref(true)
 const error = ref(null)
 const allMembers = ref([])
 
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
         // Fallback: gunakan data dari AnggotaSeeder sebagai contoh
         // Catatan: Ini hanya contoh statis jika API gagal.
         // Untuk implementasi nyata, hindari duplikasi logika dari seeder.
         allMembers.value = [] // Biarkan kosong atau buat fungsi generateFallbackMembers
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
 </style>