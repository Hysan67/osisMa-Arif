<!-- src/components/layout/Footer.vue -->
<template>
   <footer class="bg-white border-t border-gray-100 py-6 mt-16 relative overflow-visible">
     <div class="flex flex-col md:flex-row items-center justify-center gap-3 md:gap-8">
   
   <!-- Kiri -->
   <div
     class="text-xs text-gray-500 transition-all duration-300 group"
     @mouseenter="tooltip = ''"
     @mouseleave="tooltip = ''"
   >
     © {{ new Date().getFullYear() }} • Hak Cipta Dilindungi
   </div>
 
   <!-- Logo -->
   <div 
     class="flex-shrink-0 transition-transform duration-500 hover:scale-110 order-first md:order-none mb-2 md:mb-0"
     @mouseenter="logoHover = true"
     @mouseleave="logoHover = false"
   >
     <img 
       src="/logo-sekolah.png" 
       alt="Logo OSIS MA Ma’arif Udanawu" 
       class="w-14 h-14 rounded-full border-2 border-blue-100 bg-white p-1 shadow-sm"
       :class="{ 'border-blue-600 animate-pulse-slow': logoHover }"
     />
   </div>
 
   <!-- Kanan -->
   <div
     class="text-xs text-gray-500 transition-all duration-300 group"
     @mouseenter="tooltip = ''"
     @mouseleave="tooltip = ''"
   >
     Didukung oleh <span class="font-medium text-blue-600">MA Ma’arif Udanawu</span>
   </div>
 
 </div>
   </footer>
 </template>
 
 <script setup>
 import { ref } from 'vue'
 
 const logoHover = ref(false)
 const tooltip = ref('')
 </script>
 
 <style scoped>
 .animate-pulse-slow {
   animation: pulse-slow 2s infinite;
 }
 
 @keyframes pulse-slow {
   0%, 100% { box-shadow: 0 0 0 0 rgba(30, 64, 175, 0.3); }
   50% { box-shadow: 0 0 0 6px rgba(30, 64, 175, 0); }
 }
 
 .animate-fade-in {
   animation: fade-in 0.2s ease-out;
 }
 
 @keyframes fade-in {
   from { opacity: 0; transform: translateX(-50%) translateY(5px); }
   to { opacity: 1; transform: translateX(-50%) translateY(0); }
 }
 </style>