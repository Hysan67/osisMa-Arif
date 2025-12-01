<template>
  <div class="w-full">

    <!-- Foto besar -->
    <div
      class="relative rounded-2xl overflow-hidden aspect-video bg-gray-200 mb-4"
    >
      <img
        :src="photos[current]"
        class="w-full h-full object-cover transition-opacity duration-700"
        :class="fading ? 'opacity-0' : 'opacity-100'"
      />

      <!-- Tombol kiri/kanan (mobile + desktop) -->
<button
  @click="prev"
  class="absolute left-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-40 hover:bg-opacity-80 rounded-full p-2 shadow-md z-10"
>
  ‹
</button>
<button
  @click="next"
  class="absolute right-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-40 hover:bg-opacity-80 rounded-full p-2 shadow-md z-10"
>
  ›
</button>

    </div>

    <!-- Thumbnail (desktop only) -->
    <div class="hidden md:flex justify-center gap-3 mt-4">
      <div
        v-for="(p, i) in photos"
        :key="i"
        @click="go(i)"
        class="w-24 h-16 rounded-xl overflow-hidden cursor-pointer border transition"
        :class="current === i ? 'border-blue-600' : 'border-transparent'"
      >
        <img :src="p" class="w-full h-full object-cover" />
      </div>
    </div>

    <!-- Dots (mobile) -->
    <div class="md:hidden flex justify-center gap-2 mt-3">
      <button
        v-for="(p, i) in photos"
        :key="i"
        @click="go(i)"
        class="w-3 h-3 rounded-full"
        :class="current === i ? 'bg-blue-600' : 'bg-gray-400'"
      ></button>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  photos: {
    type: Array,
    required: true
  }
})

const current = ref(0)
const fading = ref(false)
let intervalId = null

const next = () => {
  fading.value = true
  setTimeout(() => {
    current.value = (current.value + 1) % props.photos.length
    fading.value = false
  }, 300)
}

const prev = () => {
  fading.value = true
  setTimeout(() => {
    current.value =
      (current.value - 1 + props.photos.length) % props.photos.length
    fading.value = false
  }, 300)
}

const go = (i) => {
  current.value = i
}

onMounted(() => {
  intervalId = setInterval(next, 3500)
})

onUnmounted(() => {
  clearInterval(intervalId)
})
</script>
