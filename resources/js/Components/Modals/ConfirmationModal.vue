<template>
   <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
     <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
       <div class="p-6">
         <div class="text-red-500 mb-4">
           <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
           </svg>
         </div>
         
         <h3 class="text-lg font-semibold text-gray-800 text-center mb-2">
           <slot name="title"></slot>
         </h3>
         <div class="text-gray-600 text-center mb-6">
           <slot name="content"></slot>
         </div>
         
         <div class="flex justify-center space-x-3">
           <button
             @click="$emit('close')"
             class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
           >
             Batal
           </button>
           <button
             @click="$emit('confirmed')"
             class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
           >
             Ya
           </button>
         </div>
       </div>
     </div>
   </div>
 </template>
 
 <script>
 export default {
   name: 'ConfirmationModal',
   
   props: {
     show: {
       type: Boolean,
       required: true
     }
   },
   
   emits: ['close', 'confirmed']
 }
 </script>