<template>
   <div class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50 p-4">
     <div class="bg-white rounded-md shadow-lg w-full max-w-6xl max-h-[80vh] flex flex-col">
       <!-- Header Modal -->
       <div class="flex-shrink-0 flex justify-between items-center p-6 border-b">
         <h3 class="text-xl font-semibold">History Artikel Terhapus</h3>
         <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
           </svg>
         </button>
       </div>
 
       <!-- Content Area yang BISA DI-SCROLL -->
       <div class="flex-1 overflow-y-auto p-6">
         <div v-if="deletedArtikels.length === 0" class="text-center py-12 text-gray-500">
           <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
           </svg>
           <p class="text-lg">Tidak ada artikel yang dihapus</p>
           <p class="text-sm mt-2">Artikel yang dihapus akan muncul di sini</p>
         </div>
 
         <div v-else>
           <div class="overflow-x-auto">
             <table class="w-full">
               <thead class="bg-gray-700 text-white">
                 <tr>
                   <th class="py-3 px-4 text-center w-12">No</th>
                   <th class="py-3 px-4 text-center w-20">Gambar</th>
                   <th class="py-3 px-4 text-left min-w-[200px]">Judul</th>
                   <th class="py-3 px-4 text-left w-24">Jenis</th>
                   <th class="py-3 px-4 text-left min-w-[180px]">Dihapus Pada</th>
                   <th class="py-3 px-4 text-center w-48">Aksi</th>
                 </tr>
               </thead>
               <tbody>
                 <tr v-for="(artikel, index) in deletedArtikels" :key="artikel.id" class="even:bg-gray-50 odd:bg-white border-b hover:bg-gray-100">
                   <td class="py-3 px-4 text-center">{{ index + 1 }}</td>
                   <td class="py-3 px-4 text-center">
                     <div class="flex justify-center">
                       <div v-if="artikel.img" class="relative group">
                         <img 
                           :src="getImageUrl(artikel.img)" 
                           :alt="artikel.judul"
                           class="w-12 h-12 object-cover rounded border border-gray-300 cursor-pointer"
                           @click="$emit('preview-image', artikel.img, artikel.judul)"
                           @error="handleImageError"
                         >
                         <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded transition-all duration-200"></div>
                       </div>
                       <div v-else class="w-12 h-12 flex items-center justify-center bg-gray-200 rounded border border-gray-300">
                         <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                         </svg>
                       </div>
                     </div>
                   </td>
                   <td class="py-3 px-4">
                     <div class="font-medium">{{ artikel.judul }}</div>
                     <div class="text-sm text-gray-500 mt-1 line-clamp-2">{{ artikel.deskripsi }}</div>
                   </td>
                   <td class="py-3 px-4">
                     <span :class="artikel.jenis_artikel === 'artikel' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'" class="px-3 py-1 rounded-full text-xs font-medium inline-block">
                       {{ artikel.jenis_artikel === 'artikel' ? 'Artikel' : 'Event' }}
                     </span>
                   </td>
                   <td class="py-3 px-4">{{ formatDate(artikel.deleted_at) }}</td>
                   <td class="py-3 px-4 text-center space-x-2">
                     <button @click="$emit('restore', artikel.id)" class="text-green-600 hover:text-green-700 px-3 py-1.5 border border-green-600 rounded hover:bg-green-50 transition-colors" title="Kembalikan">
                       <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                       </svg>
                       Restore
                     </button>
                     <button @click="$emit('permanent-delete', artikel.id)" class="text-red-600 hover:text-red-700 px-3 py-1.5 border border-red-600 rounded hover:bg-red-50 transition-colors" title="Hapus Permanen">
                       <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                       </svg>
                       Hapus
                     </button>
                   </td>
                 </tr>
               </tbody>
             </table>
           </div>
           
           <!-- Info jumlah data -->
           <div class="mt-4 px-2 py-2 text-sm text-gray-600 bg-gray-100 rounded">
             Total: {{ deletedArtikels.length }} artikel terhapus
           </div>
         </div>
       </div>
       
       <!-- Footer Modal -->
       <div class="flex-shrink-0 border-t p-4 bg-gray-50">
         <div class="flex justify-end">
           <button @click="$emit('close')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
             Tutup
           </button>
         </div>
       </div>
     </div>
   </div>
 </template>
 
 <script setup>
 defineProps({
   deletedArtikels: {
     type: Array,
     required: true,
     default: () => []
   }
 });
 
 defineEmits(['close', 'restore', 'permanent-delete', 'preview-image']);
 
 function getImageUrl(imgPath) {
   if (!imgPath) return '';
   if (imgPath.startsWith('http') || imgPath.startsWith('data:')) return imgPath;
   if (imgPath.startsWith('public/')) imgPath = imgPath.replace('public/', '');
   if (imgPath.startsWith('/')) imgPath = imgPath.substring(1);
   return `/storage/${imgPath}`;
 }
 
 function formatDate(dateString) {
   if (!dateString) return '-';
   const date = new Date(dateString);
   return date.toLocaleDateString('id-ID', {
     day: '2-digit',
     month: 'short',
     year: 'numeric',
     hour: '2-digit',
     minute: '2-digit'
   });
 }
 </script>
 
 <style scoped>
 .line-clamp-2 {
   display: -webkit-box;
   -webkit-line-clamp: 2;
   -webkit-box-orient: vertical;
   overflow: hidden;
 }
 
 .overflow-y-auto {
   overflow-y: auto;
   scrollbar-width: thin;
   scrollbar-color: #cbd5e0 #f7fafc;
 }
 
 .overflow-y-auto::-webkit-scrollbar {
   width: 8px;
 }
 
 .overflow-y-auto::-webkit-scrollbar-track {
   background: #f7fafc;
   border-radius: 4px;
 }
 
 .overflow-y-auto::-webkit-scrollbar-thumb {
   background-color: #cbd5e0;
   border-radius: 4px;
   border: 2px solid #f7fafc;
 }
 
 .overflow-y-auto::-webkit-scrollbar-thumb:hover {
   background-color: #a0aec0;
 }
 
 .group:hover .group-hover\:bg-opacity-20 {
   background-color: rgba(0, 0, 0, 0.2);
 }
 </style>