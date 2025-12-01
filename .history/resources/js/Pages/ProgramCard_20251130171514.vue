<!-- src/components/ProgramCard.vue -->
<template>
  <div class="text-center group">
    <div class="mb-4">
      <div class="w-12 h-px bg-blue-600 mx-auto group-hover:w-16 transition-all" :data-aos="aos" :data-aos-delay="delay"></div>
    </div>
    <h3 class="text-xl font-medium text-blue-600 mb-3" :data-aos="aos" :data-aos-delay="delay">{{ title }}</h3>
    <p class="text-gray-700" :data-aos="descAos" :data-aos-delay="descDelay">{{ desc }}</p>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  desc: String,
  aos: { type: String, default: 'fade-down' },
  descAos: { type: String, default: 'zoom-in-up' },
  delay: { type: Number, default: 500 },
  descDelay: { type: Number, default: 500 }
})
</script>
