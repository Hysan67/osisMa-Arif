<template>
   <div class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center z-[100] p-4">
     <div class="bg-white rounded-lg shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col">
       <div class="flex-shrink-0 flex justify-between items-center p-4 border-b">
         <h3 class="text-xl font-semibold">{{ imageTitle }}</h3>
         <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700 p-1">
           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
           </svg>
         </button>
       </div>
       <div class="flex-1 overflow-hidden p-4 flex items-center justify-center">
         <img 
           :src="imageUrl" 
           :alt="imageTitle"
           class="max-w-full max-h-full object-contain"
         >
       </div>
       <div class="flex-shrink-0 border-t p-4 text-center">
         <a :href="imageUrl" target="_blank" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
           <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
           </svg>
           Buka Gambar di Tab Baru
         </a>
       </div>
     </div>
   </div>
 </template>
 
 <script setup>
 defineProps({
   imageUrl: {
     type: String,
     required: true
   },
   imageTitle: {
     type: String,
     default: 'Preview Gambar'
   }
 });
 
 defineEmits(['close']);
 </script>
 
 <style scoped>
 @media (max-height: 640px) {
   .max-h-\[90vh\] {
     max-height: 95vh !important;
   }
 }
 </style>