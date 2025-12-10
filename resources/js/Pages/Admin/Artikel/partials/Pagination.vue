<template>
   <div class="flex items-center justify-between border-t px-4 py-3 bg-white">
     <div class="text-sm text-gray-700">
       Menampilkan {{ startItem }}-{{ endItem }} dari {{ totalItems }} artikel
     </div>
     <div class="flex space-x-1">
       <button 
         @click="goToPreviousPage"
         :disabled="currentPage === 1"
         class="px-3 py-1 border rounded text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
       >
         &larr; Sebelumnya
       </button>
       
       <template v-for="page in visiblePages" :key="page">
         <button 
           @click="$emit('page-change', page)"
           :class="currentPage === page ? 'bg-blue-600 text-white' : 'border text-gray-700 hover:bg-gray-50'"
           class="px-3 py-1 rounded text-sm"
         >
           {{ page }}
         </button>
       </template>
       
       <button 
         @click="goToNextPage"
         :disabled="currentPage === totalPages"
         class="px-3 py-1 border rounded text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
       >
         Selanjutnya &rarr;
       </button>
     </div>
   </div>
 </template>
 
 <script setup>
 import { computed } from 'vue';
 
 const props = defineProps({
   currentPage: {
     type: Number,
     required: true
   },
   totalItems: {
     type: Number,
     required: true
   },
   itemsPerPage: {
     type: Number,
     default: 10
   }
 });
 
 const emit = defineEmits(['page-change']);
 
 const totalPages = computed(() => {
   return Math.ceil(props.totalItems / props.itemsPerPage);
 });
 
 const startItem = computed(() => {
   return (props.currentPage - 1) * props.itemsPerPage + 1;
 });
 
 const endItem = computed(() => {
   const end = props.currentPage * props.itemsPerPage;
   return end > props.totalItems ? props.totalItems : end;
 });
 
 const visiblePages = computed(() => {
   const pages = [];
   const maxVisible = 5;
   
   if (totalPages.value <= maxVisible) {
     for (let i = 1; i <= totalPages.value; i++) {
       pages.push(i);
     }
   } else {
     let start = Math.max(1, props.currentPage - 2);
     let end = Math.min(totalPages.value, start + maxVisible - 1);
     
     if (end - start + 1 < maxVisible) {
       start = end - maxVisible + 1;
     }
     
     for (let i = start; i <= end; i++) {
       pages.push(i);
     }
   }
   
   return pages;
 });
 
 function goToPreviousPage() {
   if (props.currentPage > 1) {
     emit('page-change', props.currentPage - 1);
   }
 }
 
 function goToNextPage() {
   if (props.currentPage < totalPages.value) {
     emit('page-change', props.currentPage + 1);
   }
 }
 </script>