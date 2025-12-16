<!-- src/components/EventCard.vue -->
<template>
  <router-link :to="`/event/${event.id}`" class="block group" :data-aos="aos" :data-aos-delay="delay">
    <div class="md:flex gap-8 items-center">
      <div class="md:w-1/2 mb-6 md:mb-0">
        <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden shadow-md group-hover:shadow-xl transition-all duration-500">
          <img 
            :src="event.image || '/placeholder-event.jpg'" 
            :alt="event.title"
            class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105 group-hover:brightness-90"
          />
        </div>
      </div>
      <div class="md:w-1/2 text-center md:text-left">
        <h3 class="text-2xl font-light text-blue-600 mb-2" data-aos="fade-left" data-aos-delay="500">{{ event.title }}</h3>
        <p class="text-sm text-gray-500 mb-4" data-aos="zoom-in" data-aos-delay="500">{{ event.date }}</p>
        <p class="text-gray-700 max-w-2xl line-clamp-3 mx-auto md:mx-0" data-aos="zoom-in" data-aos-delay="500">{{ event.desc }}</p>
      </div>
    </div>
  </router-link>
</template>

<script setup>
defineProps({
  event: Object,
  aos: { type: String, default: 'flip-left' },
  delay: { type: Number, default: 500 }
})
</script>
