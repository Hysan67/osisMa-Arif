<template>
  <!-- Card Induk -->
  <router-link 
    :to="{ name: 'BidangDetail', params: { id: bidang.id } }"
    class="group block rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 cursor-pointer"
    :data-aos="aos" 
    :data-aos-delay="delay"
  >
    <div class="relative">
      <img 
        :src="getImageUrl(bidang.img)" 
        :alt="bidang.nama" 
        class="w-full h-56 object-cover transition-transform duration-700 group-hover:scale-110" 
        :data-aos="aos" 
        :data-aos-delay="delay" 
      />
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent transition-all duration-500 group-hover:from-black/80"></div>
      <div class="absolute bottom-0 left-0 right-0 p-5 text-white z-10 text-left">
        <h3 class="font-bold text-lg">{{ bidang.nama }}</h3>
        <p class="text-sm opacity-90 mt-1 line-clamp-2">{{ bidang.deskripsi }}</p>
      </div>
    </div>
  </router-link>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  bidang: Object,
  aos: { type: String, default: 'fade-up' },
  delay: { type: Number, default: 500 }
})

function getImageUrl(imgPath) {
  try {
    if (!imgPath || imgPath.trim() === '') {
      return 'https://via.placeholder.com/400x300?text=No+Image';
    }
    
    if (imgPath.startsWith('http://') || imgPath.startsWith('https://')) {
      return imgPath;
    }
    
    let normalizedPath = imgPath;
    
    if (normalizedPath.startsWith('public/')) {
      normalizedPath = normalizedPath.substring(7);
    }
    
    if (normalizedPath.startsWith('/')) {
      normalizedPath = normalizedPath.substring(1);
    }
    
    if (normalizedPath.includes('bidangs/')) {
      if (!normalizedPath.startsWith('storage/')) {
        return `/storage/${normalizedPath}`;
      }
      return `/${normalizedPath}`;
    }
    
    return `/storage/bidangs/${normalizedPath}`;
  } catch (error) {
    console.error('Error generating image URL:', error);
    return 'https://via.placeholder.com/400x300?text=Error+Loading';
  }
}

</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>