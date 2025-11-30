<!-- src/components/GalleryCarousel.vue -->
<template>
  <div class="relative max-w-4xl mx-auto" data-aos="flip-left" data-aos-delay="700">
    <div class="bg-gray-200 aspect-video rounded-xl flex items-center justify-center overflow-hidden" data-aos="fade-up" data-aos-delay="400">
      <span class="text-gray-600 text-lg">Foto: {{ images[currentIndex].title }}</span>
    </div>
    <button @click="prevImage" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 hover:bg-opacity-100 rounded-full p-2 shadow-md">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <button @click="nextImage" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 hover:bg-opacity-100 rounded-full p-2 shadow-md">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
    <div class="flex justify-center mt-4 space-x-2">
      <button v-for="(img,index) in images" :key="index" @click="goToImage(index)" class="w-3 h-3 rounded-full" :class="index===currentIndex?'bg-blue-600':'bg-gray-400'"></button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
defineProps({ images: Array })

const currentIndex = ref(0)
const prevImage = () => currentIndex.value = (currentIndex.value - 1 + images.length) % images.length
const nextImage = () => currentIndex.value = (currentIndex.value + 1) % images.length
const goToImage = (index) => currentIndex.value = index

// auto-slide
let interval
onMounted(() => interval = setInterval(nextImage, 6000))
onUnmounted(() => clearInterval(interval))
</script>
