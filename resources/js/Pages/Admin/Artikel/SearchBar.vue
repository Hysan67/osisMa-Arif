<template>
   <div class="mb-6">
     <div class="relative max-w-md">
       <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
         <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
         </svg>
       </div>
       <input 
         :value="modelValue"
         @input="$emit('update:modelValue', $event.target.value)"
         type="search" 
         placeholder="Cari artikel berdasarkan judul..." 
         class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
       />
       <button 
         v-if="modelValue"
         @click="$emit('clear')"
         class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
       >
         <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
         </svg>
       </button>
     </div>
     
     <!-- Search Info -->
     <div v-if="modelValue" class="mt-2 text-sm text-gray-600">
       <span v-if="resultCount > 0">
         Menampilkan {{ resultCount }} dari {{ totalCount }} artikel untuk pencarian: 
         "<span class="font-semibold">{{ modelValue }}</span>"
       </span>
       <span v-else>
         Tidak ditemukan artikel dengan judul: 
         "<span class="font-semibold">{{ modelValue }}</span>"
       </span>
     </div>
   </div>
 </template>
 
 <script setup>
 defineProps({
   modelValue: {
     type: String,
     default: ''
   },
   resultCount: {
     type: Number,
     default: 0
   },
   totalCount: {
     type: Number,
     default: 0
   }
 });
 
 defineEmits(['update:modelValue', 'clear']);
 </script>
 
 <style scoped>
 input:focus {
   outline: none;
   ring: 2px;
 }
 </style>