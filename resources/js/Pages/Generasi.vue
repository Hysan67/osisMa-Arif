<!-- src/pages/Generasi.vue -->
<template>
   <div class="min-h-screen bg-white">
     <div class="max-w-5xl mx-auto px-4 py-16">
       <router-link to="/" class="text-osisBlue hover:underline mb-8 inline-block font-light">&larr; Kembali ke Beranda</router-link>
 
       <div class="text-center mb-20">
         <h1 class="text-5xl font-light text-osisBlue mb-6">Generasi Pengurus OSIS</h1>
         <p class="text-gray-700 max-w-3xl mx-auto text-lg">
           Sejak berdiri, OSIS MA Ma’arif Udanawu telah melahirkan banyak generasi pemimpin yang aktif, kreatif, dan berakhlak mulia.
         </p>
       </div>
 
       <div class="space-y-24">
         <div v-for="(gen, i) in generations" :key="i" class="md:flex items-start gap-10" :class="{ 'flex-row-reverse': i % 2 === 1 }">
           <div class="md:w-2/5 mb-8 md:mb-0 flex justify-center">
             <div class="w-40 h-40 rounded-full bg-gray-200 flex items-center justify-center text-4xl text-gray-500">
               {{ gen.initials }}
             </div>
           </div>
           <div class="md:w-3/5">
             <h2 class="text-3xl font-light text-osisBlue mb-4">{{ gen.period }}</h2>
             <h3 class="text-xl font-medium text-gray-900 mb-1">{{ gen.name }}</h3>
             <p class="text-gray-600 mb-4">{{ gen.role }}</p>
             <p class="text-gray-800 mb-6 leading-relaxed">{{ gen.desc }}</p>
             <ul class="space-y-2">
               <li v-for="(item, j) in gen.highlights" :key="j" class="flex items-start">
                 <span class="text-osisBlue mr-3 mt-1">•</span>
                 <span class="text-gray-800 font-light">{{ item }}</span>
               </li>
             </ul>
           </div>
         </div>
       </div>
     </div>
   </div>
 </template>
 
 <script setup>
 const generations = [
   {
     period: 'Periode 2024/2025',
     name: 'Ahmad Fauzi',
     role: 'Ketua OSIS',
     initials: 'AF',
     desc: 'Fokus pada pengembangan karakter islami, peningkatan prestasi akademik-nonakademik, serta penguatan kerja sama antar bidang.',
     highlights: [
       'Penyelenggaraan Ma’arif Cup VI',
       'Pengajian Rutin Setiap Jumat',
       'Pelatihan Jurnalistik & Desain Grafis'
     ]
   },
   {
     period: 'Periode 2023/2024',
     name: 'Dinda Rahmawati',
     role: 'Ketua OSIS',
     initials: 'DR',
     desc: 'Sukses menggelar Bazar Amal dan MTQ Antar Kelas, serta memperkuat dokumentasi kegiatan melalui media sosial.',
     highlights: [
       'MTQ Tingkat Madrasah',
       'Bakti Sosial ke Panti Asuhan',
       'Pelatihan Public Speaking'
     ]
   }
   // Tambahkan data lain jika diperlukan
 ]
 </script>