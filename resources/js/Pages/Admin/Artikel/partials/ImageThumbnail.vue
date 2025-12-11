<template>
   <div class="flex justify-center">
     <div v-if="imgPath" class="relative group">
       <img 
         :src="getImageUrl(imgPath)" 
         :alt="alt"
         class="w-12 h-12 object-cover rounded border border-gray-300 cursor-pointer"
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
 </template>
 
 <script setup>
 defineProps({
   imgPath: {
     type: String,
     default: ''
   },
   alt: {
     type: String,
     default: 'Image'
   }
 });
 
 function getImageUrl(imgPath) {
   if (!imgPath) return '';
   if (imgPath.startsWith('http') || imgPath.startsWith('data:')) return imgPath;
   if (imgPath.startsWith('public/')) imgPath = imgPath.replace('public/', '');
   if (imgPath.startsWith('/')) imgPath = imgPath.substring(1);
   return `/storage/${imgPath}`;
 }
 </script>
 
 <style scoped>
 .group:hover .group-hover\:bg-opacity-20 {
   background-color: rgba(0, 0, 0, 0.2);
 }
 
 img {
   transition: transform 0.2s ease;
 }
 
 img:hover {
   transform: scale(1.05);
 }
 </style>