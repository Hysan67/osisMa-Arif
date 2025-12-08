<template>
   <div class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50">
     <div class="bg-white rounded-md shadow-lg max-w-lg w-full p-6">
       <h3 class="text-xl font-semibold mb-4">{{ isEdit ? "Edit Artikel" : "Artikel Baru" }}</h3>
 
       <form @submit.prevent="$emit('save')">
         <div class="mb-4">
           <label class="block mb-1 font-medium">Judul</label>
           <input v-model="formData.judul" class="w-full border px-3 py-2 rounded" required />
         </div>
 
         <div class="mb-4">
           <label class="block mb-1 font-medium">Dheskripsi</label>
           <textarea v-model="formData.deskripsi" rows="4" class="w-full border px-3 py-2 rounded" required></textarea>
         </div>
 
         <div class="mb-4">
           <label class="block mb-1 font-medium">Jenis Artikel</label>
           <select v-model="formData.jenis_artikel" class="w-full border px-3 py-2 rounded" required>
             <option value="artikel">Artikel</option>
             <option value="event">Event</option>
           </select>
         </div>
 
         <div class="mb-4">
           <label class="block mb-1 font-medium">Gambar (Opsional)</label>
           <div v-if="formData.img && formData.img.name" class="mb-3">
             <p class="text-sm text-gray-600 mb-1">File dipilih: {{ formData.img.name }}</p>
             <img v-if="formData.imgPreview" :src="formData.imgPreview" class="w-32 h-32 object-cover rounded border">
           </div>
           <input type="file" @change="$emit('file-upload', $event)" class="w-full border px-3 py-2 rounded" accept="image/*" />
           <p class="text-sm text-gray-500 mt-1">format: jpeg, png, jpg, gif</p>
         </div>
 
         <div class="flex justify-end space-x-3">
           <button type="button" @click="$emit('close')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
           <button type="submit" class="px-4 py-2 bg-[#1E40AF] text-white rounded hover:bg-[#1E3A8A]">
             {{ isEdit ? "Update" : "Simpan" }}
           </button>
         </div>
       </form>
     </div>
   </div>
 </template>
 
 <script setup>
 defineProps({
   isEdit: Boolean,
   formData: Object
 });
 
 defineEmits(['save', 'close', 'file-upload']);
 </script>