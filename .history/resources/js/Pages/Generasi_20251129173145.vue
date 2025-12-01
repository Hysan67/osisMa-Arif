<!-- src/pages/Generasi.vue -->
<template>
  <div class="min-h-screen bg-transparant py-16">
    <div class="max-w-5xl mx-auto px-4 py-16">
      <router-link to="/" class="text-blue-600 hover:underline mb-8 inline-block font-light">&larr; Kembali ke Beranda</router-link>

      <div class="text-center mb-20">
        <h1 class="text-5xl font-light text-blue-600 mb-6" data-aos="fade-right" data-aos-delay="500">Generasi Pengurus OSIS</h1>
        <p class="text-gray-700 max-w-3xl mx-auto text-lg" data-aos="fade-left" data-aos-delay="500">
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
            <h2 class="text-3xl font-light text-blue-600 mb-4">{{ gen.period }}</h2>
            <h3 class="text-xl font-medium text-gray-900 mb-1">{{ gen.name }}</h3>
            <p class="text-gray-600 mb-4">{{ gen.role }}</p>
            <p class="text-gray-800 mb-6 leading-relaxed">{{ gen.desc }}</p>
            <ul class="space-y-2">
            <li v-for="(item, j) in gen.highlights" :key="j" class="flex items-start">
              <span class="text-blue-600 mr-3 mt-1">•</span>
              <span class="text-gray-800 font-light">{{ item }}</span>
            </li>
          </ul>

          <!-- Carousel Foto Generasi -->
          <div class="relative mt-10" v-if="gen.photos && gen.photos.length">
            <div class="bg-gray-200 aspect-video rounded-xl overflow-hidden flex items-center justify-center">
              <img
              :src="gen.photos[photoIndex[i]]"
              alt="Foto generasi"
              class="w-full h-full object-cover transition-opacity duration-700"
              :class="isFading[i] ? 'opacity-0' : 'opacity-100'"
            />
            </div>

            <!-- Navigasi -->
            <button
              @click="prevPhoto(i)"
              class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 hover:bg-opacity-100 rounded-full p-2 shadow-md"
            >
              ‹
            </button>
            <button
              @click="nextPhoto(i)"
              class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 hover:bg-opacity-100 rounded-full p-2 shadow-md"
            >
              ›
            </button>

            <!-- Dots -->
            <div class="flex justify-center mt-4 space-x-2">
              <button
                v-for="(p, k) in gen.photos"
                :key="k"
                @click="goToPhoto(i, k)"
                class="w-3 h-3 rounded-full"
                :class="photoIndex[i] === k ? 'bg-blue-600' : 'bg-gray-400'"
              ></button>
            </div>
          </div>
                <span class="text-gray-800 font-light">{{ item }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

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
    ],
    photos: [
      '/generasi/2024-inti.jpg',
      '/generasi/2024-bidang1.jpg',
      '/generasi/2024-bidang2.jpg',
      '/generasi/2024-bidang3.jpg',
      '/generasi/2024-bidang4.jpg',
      '/generasi/2024-bidang5.jpg',
      '/generasi/2024-bidang6.jpg'
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
    ],
    photos: [
      '/generasi/2023-inti.jpg',
      '/generasi/2023-bidang1.jpg',
      '/generasi/2023-bidang2.jpg',
      '/generasi/2023-bidang3.jpg',
      '/generasi/2023-bidang4.jpg',
      '/generasi/2023-bidang5.jpg',
      '/generasi/2023-bidang6.jpg'
    ]
  }
]

const photoIndex = ref(generations.map(() => 0))
const isFading = ref(generations.map(() => false))

const autoSlide = () => {
  generations.forEach((_, i) => {
    isFading.value[i] = true
    setTimeout(() => {
      nextPhoto(i)
      isFading.value[i] = false
    }, 400)
  })
}
setInterval(autoSlide, 4000) // otomatis berganti setiap 4 detik

const nextPhoto = (i) => {
  isFading.value[i] = true
  setTimeout(() => {
    photoIndex.value[i] = (photoIndex.value[i] + 1) % generations[i].photos.length
    isFading.value[i] = false
  }, 400)
}

const prevPhoto = (i) => {
  isFading.value[i] = true
  setTimeout(() => {
    photoIndex.value[i] =
      (photoIndex.value[i] - 1 + generations[i].photos.length) % generations[i].photos.length
    isFading.value[i] = false
  }, 400)
}
const goToPhoto = (i, k) => {
  photoIndex.value[i] = k
}
</script>
