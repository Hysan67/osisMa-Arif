<template>
   <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
     <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
       <!-- Modal Header -->
       <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
         <div>
           <h2 class="text-xl font-semibold text-gray-800">{{ anggota.nama }}</h2>
           <p class="text-sm text-gray-600">{{ anggota.posisi }}</p>
         </div>
         <button @click="$emit('close')" class="text-gray-400 hover:text-gray-600">
           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
           </svg>
         </button>
       </div>
 
       <!-- Modal Body -->
       <div class="p-6">
         <div class="flex flex-col md:flex-row gap-6">
           <!-- Left Column - Image and Basic Info -->
           <div class="md:w-1/3">
             <div class="mb-6">
               <img
                 :src="getImageUrl(anggota.img)"
                 :alt="anggota.nama"
                 class="w-full h-64 object-cover rounded-lg"
                 @error="handleImageError"
               />
             </div>
             
             <!-- Status and Badges -->
             <div class="space-y-4">
               <div class="flex items-center justify-between">
                 <span 
                   :class="anggota.status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                   class="px-3 py-1 rounded-full text-sm font-medium"
                 >
                   {{ anggota.status === 'aktif' ? 'Aktif' : 'Non Aktif' }}
                 </span>
                 
                 <span v-if="bidang" class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                   {{ bidang.nama }}
                 </span>
               </div>
               
               <div>
                 <h4 class="text-sm font-medium text-gray-700 mb-1">Masa Bakti</h4>
                 <p class="text-lg font-semibold text-gray-900">{{ anggota.masa_bakti }}</p>
               </div>
             </div>
           </div>
 
           <!-- Right Column - Details -->
           <div class="md:w-2/3">
             <!-- Quote -->
             <div class="mb-6 p-4 bg-yellow-50 border border-yellow-100 rounded-lg">
               <h4 class="text-sm font-medium text-yellow-800 mb-2">Quote / Motto</h4>
               <p class="text-lg italic text-yellow-900">"{{ anggota.quote }}"</p>
             </div>
 
             <!-- Pengalaman & Prestasi -->
             <div class="mb-6">
               <h4 class="text-lg font-semibold text-gray-800 mb-3">Pengalaman & Prestasi</h4>
               <div class="prose prose-sm max-w-none">
                 <p class="text-gray-700 whitespace-pre-line">{{ anggota.pengalaman_prestasi }}</p>
               </div>
             </div>
 
             <!-- Additional Info -->
             <div class="grid grid-cols-2 gap-4">
               <div>
                 <h4 class="text-sm font-medium text-gray-700 mb-1">Tanggal Dibuat</h4>
                 <p class="text-gray-900">{{ formatDate(anggota.created_at) }}</p>
               </div>
               <div>
                 <h4 class="text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</h4>
                 <p class="text-gray-900">{{ formatDate(anggota.updated_at) }}</p>
               </div>
             </div>
           </div>
         </div>
 
         <!-- Actions -->
         <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
           <button
             @click="$emit('close')"
             class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
           >
             Tutup
           </button>
           <button
             @click="$emit('edit')"
             class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
           >
             Edit Anggota
           </button>
         </div>
       </div>
     </div>
   </div>
 </template>
 
 <script>
 export default {
   name: 'DetailAnggota',
   
   props: {
     anggota: {
       type: Object,
       required: true
     },
     bidang: {
       type: Object,
       default: null
     },
     show: {
       type: Boolean,
       required: true
     }
   },
   
   emits: ['close', 'edit'],
   
   setup() {
     const getImageUrl = (imgPath) => {
       if (!imgPath) return 'https://via.placeholder.com/400x300?text=No+Image'
       if (imgPath.startsWith('http')) return imgPath
       return `/storage/${imgPath}`
     }
     
     const formatDate = (dateString) => {
       if (!dateString) return ''
       const date = new Date(dateString)
       return date.toLocaleDateString('id-ID', {
         year: 'numeric',
         month: 'long',
         day: 'numeric',
         hour: '2-digit',
         minute: '2-digit'
       })
     }
 
     return {
       getImageUrl,
       formatDate
     }
   }
 }
 </script>