<!-- src/components/BidangCard.vue -->
<template>
  <router-link :to="`/bidang/${bidang.id}`" class="group block rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" :data-aos="aos" :data-aos-delay="delay">
    <div class="relative">
      <img :src="bidang.image" :alt="bidang.name" class="w-full h-56 object-cover transition-transform duration-700 group-hover:scale-110" :data-aos="aos" :data-aos-delay="delay" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent transition-all duration-500 group-hover:from-black/80"></div>
      <div class="absolute bottom-0 left-0 right-0 p-5 text-white z-10 text-left">
        <h3 class="font-bold text-lg">{{ bidang.name }}</h3>
        <p class="text-sm opacity-90 mt-1">{{ bidang.desc }}</p>
      </div>
    </div>
  </router-link>
</template>

<script setup>
defineProps({
  bidang: Object,
  aos: { type: String, default: 'fade-up' },
  delay: { type: Number, default: 500 }
})
</script>
