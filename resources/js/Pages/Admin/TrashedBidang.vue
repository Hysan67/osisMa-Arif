<template>
   <div class="container mx-auto px-4 py-8">
     <!-- Status Message -->
     <div v-if="statusMessage" class="mb-6 p-4 rounded-lg shadow-md" :class="statusType === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'">
       {{ statusMessage }}
     </div>
 
     <!-- Header -->
     <div class="mb-8">
       <div class="flex justify-between items-center">
         <div>
           <h1 class="text-3xl font-bold text-gray-800 mb-2">Bidang yang Dihapus</h1>
           <p class="text-gray-600">Kelola data bidang OSIS yang telah dihapus</p>
         </div>
         <router-link 
           to="/admin/kelola-bidang"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition"
         >
           <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
           </svg>
           Kembali ke Bidang
         </router-link>
       </div>
     </div>
 
     <!-- Loading State -->
     <div v-if="loading" class="text-center py-12">
       <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
       <p class="mt-4 text-gray-600">Memuat data bidang yang dihapus...</p>
     </div>
 
     <!-- Error State -->
     <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-6 text-center mb-6">
       <div class="text-red-600 mb-2">
         <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
         </svg>
       </div>
       <h3 class="text-lg font-medium text-red-800 mb-2">Gagal memuat data</h3>
       <p class="text-red-700 mb-4">{{ error }}</p>
       <button
         @click="fetchTrashedBidangs"
         class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg"
       >
         Coba Lagi
       </button>
     </div>
 
     <!-- Empty State -->
     <div v-else-if="bidangs.length === 0" class="bg-white rounded-lg shadow p-8 text-center">
       <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
       </svg>
       <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada bidang yang dihapus</h3>
       <p class="text-gray-600 mb-6">Semua bidang saat ini aktif</p>
     </div>
 
     <!-- Bidang Table -->
     <div v-else class="bg-white rounded-lg shadow overflow-hidden">
       <div class="overflow-x-auto">
         <table class="min-w-full divide-y divide-gray-200">
           <thead class="bg-gray-50">
             <tr>
               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Gambar
               </th>
               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Nama Bidang
               </th>
               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Deskripsi
               </th>
               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Dihapus Pada
               </th>
               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Aksi
               </th>
             </tr>
           </thead>
           <tbody class="bg-white divide-y divide-gray-200">
             <tr v-for="bidang in bidangs" :key="bidang.id">
               <td class="px-6 py-4 whitespace-nowrap">
                 <img
                   :src="getImageUrl(bidang.img)"
                   :alt="bidang.nama"
                   class="w-16 h-16 object-cover rounded"
                   @error="handleImageError"
                 />
               </td>
               <td class="px-6 py-4 whitespace-nowrap">
                 <div class="text-sm font-medium text-gray-900">{{ bidang.nama }}</div>
               </td>
               <td class="px-6 py-4">
                 <div class="text-sm text-gray-900 line-clamp-2">{{ bidang.deskripsi }}</div>
               </td>
               <td class="px-6 py-4 whitespace-nowrap">
                 <div class="text-sm text-gray-900">{{ formatDate(bidang.deleted_at) }}</div>
               </td>
               <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                 <button
                   @click="restoreBidang(bidang)"
                   class="text-green-600 hover:text-green-900 mr-4"
                 >
                   Pulihkan
                 </button>
                 <button
                   @click="confirmForceDelete(bidang)"
                   class="text-red-600 hover:text-red-900"
                 >
                   Hapus Permanen
                 </button>
               </td>
             </tr>
           </tbody>
         </table>
       </div>
     </div>
   </div>
 </template>
 
 <script setup>
 import { ref, onMounted } from "vue";
 import axios from "axios";
 import { useRouter } from "vue-router";
 
 const router = useRouter();
 const bidangs = ref([]);
 const loading = ref(false);
 const error = ref("");
 const statusMessage = ref("");
 const statusType = ref("");
 
 function showStatus(msg, type = "success") {
   statusMessage.value = msg;
   statusType.value = type;
   setTimeout(() => {
     if (statusMessage.value === msg) {
       statusMessage.value = "";
       statusType.value = "";
     }
   }, 3000);
 }
 
 function getImageUrl(imgPath) {
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
 
 function handleImageError(event) {
   event.target.src = 'https://via.placeholder.com/400x300?text=No+Image';
 }
 
 function formatDate(dateString) {
   if (!dateString) return '';
   const date = new Date(dateString);
   return date.toLocaleDateString('id-ID', {
     year: 'numeric',
     month: 'long',
     day: 'numeric',
     hour: '2-digit',
     minute: '2-digit'
   });
 }
 
 async function fetchTrashedBidangs() {
   loading.value = true;
   error.value = "";
   
   try {
     const token = localStorage.getItem('token');
     const response = await axios.get('/bidang/trashed', {
       headers: {
         'Authorization': `Bearer ${token}`,
         'Accept': 'application/json'
       }
     });
     
     bidangs.value = response.data.data || response.data;
   } catch (err) {
     console.error('Error fetching trashed bidangs:', err);
     error.value = 'Gagal memuat data bidang yang dihapus. Silakan coba lagi.';
     showStatus("Gagal memuat bidang yang dihapus: " + (err.response?.data?.message || "Error"), "error");
   } finally {
     loading.value = false;
   }
 }
 
 async function restoreBidang(bidang) {
   if (!confirm(`Apakah Anda yakin ingin memulihkan bidang "${bidang.nama}"?`)) {
     return;
   }
 
   try {
     const token = localStorage.getItem('token');
     await axios.post(`/bidang/restore/${bidang.id}`, {}, { 
       headers: {
         'Authorization': `Bearer ${token}`,
         'Accept': 'application/json'
       }
     });
     
     showStatus(`Bidang "${bidang.nama}" berhasil dipulihkan`, "success");
     await fetchTrashedBidangs();
   } catch (err) {
     console.error('Error restoring bidang:', err);
     showStatus("Gagal memulihkan bidang: " + (err.response?.data?.message || "Error"), "error");
   }
 }
 
 async function confirmForceDelete(bidang) {
   if (!confirm(`Apakah Anda yakin ingin menghapus PERMANEN bidang "${bidang.nama}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
     return;
   }
 
   try {
     const token = localStorage.getItem('token');
     await axios.delete(`/bidang/force/${bidang.id}`, {
       headers: {
         'Authorization': `Bearer ${token}`,
         'Accept': 'application/json'
       }
     });
     
     showStatus(`Bidang "${bidang.nama}" berhasil dihapus permanen`, "success");
     await fetchTrashedBidangs();
   } catch (err) {
     console.error('Error force deleting bidang:', err);
     showStatus("Gagal menghapus permanen bidang: " + (err.response?.data?.message || "Error"), "error");
   }
 }
 
 onMounted(() => {
   fetchTrashedBidangs();
 });
 </script>
 
 <style scoped>
 .line-clamp-2 {
   display: -webkit-box;
   -webkit-line-clamp: 2;
   -webkit-box-orient: vertical;
   overflow: hidden;
 }
 </style>