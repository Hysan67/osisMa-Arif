<!-- src/pages/Event.vue -->
<template>
  <div class="min-h-screen bg-transparant py-16">
    <div class="max-w-5xl mx-auto px-4 py-16">
      <router-link to="/" class="text-blue-600 hover:underline mb-8 inline-block font-light">&larr; Kembali ke Beranda</router-link>

      <div class="text-center mb-20">
        <h1 class="text-5xl font-light text-blue-600" data-aos="fade-up" data-aos-delay="500">Event</h1>
        <div class="w-16 h-px bg-osisGold mx-auto mt-6"></div>
        <p class="text-gray-600 mt-8 max-w-2xl mx-auto" data-aos="fade-left" data-aos-delay="500">
          Simak dokumentasi lengkap kegiatan OSIS MA Ma’arif Udanawu dari masa ke masa.
        </p>
      </div>

      <div v-if="eventStore.loading" class="text-center py-12 text-gray-500">
        Memuat data...
      </div>

      <div v-else-if="eventStore.events.length === 0" class="text-center py-12 text-gray-500">
        Belum ada event yang dipublikasikan.
      </div>

      <div v-else class="space-y-16">
        <router-link
          v-for="event in eventStore.events"
          :key="event.id"
          :to="`/event/${event.id}`"
          class="block group"
          data-aos="fade-up"
          :data-aos-delay="event.id * 400"
        >
          <div class="md:flex gap-10 items-start">
            <div class="md:w-2/5 mb-6 md:mb-0">
              <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden">
                <img
                  :src="event.image || '/placeholder-event.jpg'"
                  :alt="event.title"
                  class="w-full h-full object-cover transition-all duration-500 
                      group-hover:scale-105 group-hover:brightness-90"
                />
              </div>
            </div>
            <div class="md:w-3/5">
              <h2 class="text-2xl font-light text-blue-600 group-hover:text-opacity-90 transition mb-2" data-aos="fade-left" data-aos-delay="500">
                {{ event.title }}
              </h2>
              <p class="text-gray-500 text-sm mb-3">{{ event.date }}</p>
              <p class="text-gray-700 leading-relaxed">
                {{ event.desc }}
              </p>
            </div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useEventStore } from '../store/useEventStore'

const eventStore = useEventStore()

onMounted(() => {
  eventStore.fetchEvents()
})
</script>