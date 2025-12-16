<template>
  <div class="bg-blue-50 py-20">
    <div class="max-w-6xl mx-auto px-4" data-aos="fade-up" data-aos-delay="500">
      <h2 class="text-4xl font-light text-center text-blue-600 mb-16">Event Besar Kami</h2>

      <div v-if="!props.events?.length" class="text-center py-12 text-gray-500">
        Tidak ada event besar saat ini.
      </div>

      <div v-else class="space-y-20">
        <div
          v-for="(event, index) in props.events"
          :key="event.id"
          :class="['md:flex items-center gap-8', index % 2 !== 0 ? 'md:flex-row-reverse' : '']"
          :data-aos="index % 2 === 0 ? 'fade-right' : 'fade-left'"
          data-aos-delay="400"
        >
          <div class="md:w-1/2 mb-6 md:mb-0">
            <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden">
              <img
                :src="event.image || '/images/placeholder-event.jpg'"
                :alt="event.title"
                class="w-full h-full object-cover"
              />
            </div>
          </div>
          <div class="md:w-1/2 text-center md:text-left">
            <h3 class="text-2xl font-light text-blue-600 mb-4">{{ event.title }}</h3>
            <p class="text-gray-700 line-clamp-3">{{ event.desc }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  events: {
    type: Array,
    default: () => []
  }
})
</script>