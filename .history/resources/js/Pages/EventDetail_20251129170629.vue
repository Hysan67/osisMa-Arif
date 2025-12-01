<!-- src/pages/EventDetail.vue -->
<template>
  <div class="min-h-screen bg-transparant py-16">
    <div class="max-w-5xl mx-auto px-4 py-16">
      <router-link to="/event" class="text-blue-600 hover:underline mb-8 inline-block font-light">&larr; Kembali ke Daftar Event</router-link>

      <div v-if="!event" class="text-center py-20 text-gray-500">
        Memuat kisah kegiatan...
      </div>

      <article v-else>
        <!-- Gambar besar (editorial style) -->
        <div class="rounded-2xl overflow-hidden mb-16 shadow-sm">
          <div class="aspect-video bg-gray-200 flex items-center justify-center">
            <span class="text-white text-xl font-light" data-aos="fade-left" data-aos-delay="500">Dokumentasi: {{ event.title }}</span>
          </div>
        </div>

        <!-- Konten -->
        <div class="prose prose-lg max-w-none">
          <h1 class="text-5xl font-light text-blue-600 mb-4">{{ event.title }}</h1>
          <p class="text-gray-500 text-lg mb-10">{{ event.date }}</p>

          <!-- Tema -->
          <div v-if="event.theme" class="mb-12">
            <div class="pl-6 border-l-2 border-yellow-300">
              <p class="italic text-xl text-gray-800 font-light">“{{ event.theme }}”</p>
            </div>
          </div>

          <!-- Cerita -->
          <div class="space-y-6 text-gray-800 leading-relaxed">
            <p v-for="(paragraph, i) in event.story" :key="i">{{ paragraph }}</p>
          </div>

          <!-- Penutup -->
          <div class="mt-16 pt-8 border-t border-gray-100">
            <p class="text-gray-700 mb-4">
              Untuk teman-teman santri yang turut serta, kami segenap panitia
              <span class="font-medium text-blue-600">OSIS MA Ma’arif Udanawu</span>
              mengucapkan:
            </p>
            <p class="text-3xl font-light text-blue-600">
              {{ event.closingGreeting }}
            </p>
            <p class="mt-6 text-gray-600">
              Semoga kegiatan ini menjadi wasilah keberkahan, kebersamaan, dan semangat untuk terus berkarya di jalan Allah SWT.
            </p>
            <br/> 
            <!-- Carousel Foto Event -->
            <div class="mt-10" v-if="event.photos && event.photos.length">
              <PhotoSlider :photos="event.photos" />
            </div>
            <br/>
            <!-- Tombol bagikan -->
            <div class="flex items-center gap-3 mb-10">
              <button
                @click="shareEvent"
                class="flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-600 transition-colors"
              >
                <i class="fas fa-share-alt"></i>
                <span>Bagikan</span>
              </button>

              <button
                @click="copyLink"
                class="flex items-center gap-2 px-4 py-2 rounded-full border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors"
              >
                <i class="fas fa-link"></i>
                <span>Salin Link</span>
              </button>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useEventStore } from '../store/useEventStore'
import PhotoSlider from '@/Pages/PhotoSlider.vue'

const route = useRoute()
const store = useEventStore()
const event = ref(null)

onMounted(async () => {
  const data = await store.fetchEventById(route.params.id)
  if (data) {
    event.value = {
      ...data,
      theme: data.theme || '',
      story: data.story ? data.story.split('\n') : [data.desc],
      closingGreeting: data.closingGreeting || 'Barakallahu fiikum!'
    }
  }
})

// fungsi untuk salin link
function copyLink() {
  const link = window.location.href
  navigator.clipboard.writeText(link)
  alert('Link event disalin ke clipboard!')
}

// fungsi untuk share (pakai Web Share API kalau tersedia)
function shareEvent() {
  const link = window.location.href
  if (navigator.share) {
    navigator.share({
      title: event.value.title,
      text: 'Yuk baca kisah kegiatan OSIS!',
      url: link
    })
  } else {
    copyLink()
  }
}
</script>