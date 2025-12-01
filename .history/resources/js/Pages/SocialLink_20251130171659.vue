<!-- src/components/SocialLink.vue -->
<template>
  <a :href="url" target="_blank" rel="noopener noreferrer"
     class="group block p-6 rounded-3xl bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-10 hover:bg-opacity-20 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
     :aria-label="`Ikuti kami di ${name}`">
    <div class="flex justify-center mb-4">
      <div :class="iconBgClasses" class="w-14 h-14 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
        <slot />
      </div>
    </div>
    <h3 class="font-semibold text-lg">{{ name }}</h3>
    <p class="text-sm opacity-80 mt-1">{{ handle }}</p>
  </a>
</template>

<script setup>
defineProps({
  name: String,
  handle: String,
  url: String,
  iconBgClasses: { type: String, default: 'bg-gradient-to-br from-pink-500 to-rose-600' }
})
</script>
