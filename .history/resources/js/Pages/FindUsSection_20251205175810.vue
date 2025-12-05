<template>
  <div class="relative bg-gradient-to-t from-blue-600 to-transparant-40 text-white py-24 px-4 overflow-x-hidden w-full">
    <div class="absolute top-10 left-10 w-32 h-32 rounded-full bg-yellow-300 bg-opacity-10 blur-xl pointer-events-none"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 rounded-full bg-white bg-opacity-5 blur-2xl pointer-events-none"></div>
    <div class="max-w-4xl mx-auto text-center relative z-10" data-aos="flip-right" data-aos-delay="400">
      <div class="mb-6">
        <div class="w-16 h-1 bg-yellow-300 mx-auto rounded-full"></div>
      </div>
      <h2 class="text-3xl md:text-4xl font-light mb-4 text-blue-400 drop-shadow-lg">Temukan Kami</h2>
      <p class="text-white/90 max-w-2xl mx-auto mb-12 leading-relaxed">
        Ikuti setiap langkah, karya, dan kegiatan OSIS MA Ma’arif Udanawu melalui platform berikut.
      </p>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-2xl mx-auto">
        <slot />
      </div>

      <p class="mt-10 text-sm opacity-70">
        Kami selalu terbuka untuk kolaborasi, saran, atau pertanyaan!
      </p>
    </div>
  </div>
</template>

<script setup>
</script>
