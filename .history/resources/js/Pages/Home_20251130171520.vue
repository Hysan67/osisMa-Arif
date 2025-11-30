<template>
  <div class="min-h-screen w-full bg-transparent overflow-x-hidden">

    <!-- Hero Section -->
    <div class="min-h-[70vh] flex flex-col items-center justify-center px-4 text-center relative">
      <div class="absolute inset-0 -z-10 bg-[url('/background-header.JPG')] bg-cover bg-center"></div>
      <div class="absolute inset-0 -z-5 bg-gradient-to-b from-white/50 to-white/100"></div>
      <div class="max-w-4xl relative z-10">
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-light tracking-tight leading-none mb-6" data-aos="fade-down" data-aos-delay="500">
          <br />
          OSIS<br />
          MA MA’ARIF<br />
          UDANAWU
        </h1>
        <p class="text-lg md:text-xl text-gray-600 mt-8 font-light tracking-wide" data-aos="fade-up" data-aos-delay="500">
          We may be a<br />
          <span class="font-medium">leadership</span><br />
          <span class="font-medium">warehouse</span>
        </p>
        <p class="text-gray-500 mt-12 text-sm uppercase tracking-widest" data-aos="fade-in" data-aos-delay="500">
          What we’re good at
        </p>
      </div>
    </div>

    <!-- Program Unggulan -->
    <section class="relative py-16">
      <div class="absolute inset-0 -z-10 bg-[url('/background-program.svg')] bg-cover bg-top bg-no-repeat"></div>
      <div class="absolute inset-0 -z-5 bg-gradient-to-t from-white/30 to-white/100"></div>
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-light text-blue-600" data-aos="fade-left" data-aos-delay="500">Program Unggulan</h2>
          <p class="text-gray-600 mt-4 max-w-2xl mx-auto" data-aos="fade-right" data-aos-delay="500">
            Yuk, simak kegiatan utama OSIS MA Ma’arif Udanawu!
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <ProgramCard v-for="(p,i) in programs" :key="i" :title="p.title" :desc="p.desc" :delay="i*200" :desc-delay="i*300" />
        </div>
      </div>
    </section>

    <!-- Event Terkini -->
    <div class="w-full bg-white px-4 py-20">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-light text-blue-600" data-aos="fade-left" data-aos-delay="500">Event OSIS Terkini</h2>
        <p class="text-gray-600 mt-4" data-aos="fade-right" data-aos-delay="500">Yuk, simak cerita kami dalam berbagai kegiatan OSIS!</p>
      </div>

      <div v-if="eventStore.loading" class="text-center py-8 text-gray-500">Memuat event terbaru...</div>
      <div v-else-if="recentEvents.length" class="space-y-16">
        <EventCard v-for="event in recentEvents" :key="event.id" :event="event" :delay="event.id*400"/>
      </div>
      <div v-else class="text-center py-8 text-gray-500" data-aos="fade-up" data-aos-delay="500">Belum ada event terbaru.</div>

      <div class="text-center mt-12">
        <router-link to="/event" class="inline-block px-6 py-3 text-blue-600 font-medium border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-colors" data-aos="fade-right">
          Lihat Semua Event
        </router-link>
      </div>
    </div>

    <!-- Bidang OSIS -->
    <div class="py-16 relative" data-aos="fade-up" data-aos-delay="500">
      <div class="absolute inset-0 -z-10 bg-[url('/background-bidang.svg')] bg-cover bg-top bg-no-repeat">
        <div class="absolute inset-0 -z-5 bg-gradient-to-b from-transparent to-white/100"></div>
      </div>
      <div class="max-w-6xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-light text-white mb-4">BIDANG</h2>
        <p class="text-white mb-12 max-w-3xl mx-auto">
          OSIS MA Ma’arif Udanawu terbagi menjadi 6 bidang untuk fokus menjalankan tugas dan program kerja masing-masing.
        </p>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <BidangCard v-for="b in bidangs" :key="b.id" :bidang="b" :delay="b.id*200"/>
        </div>
      </div>
    </div>

    <!-- Galeri Mini -->
    <section class="relative py-16 overflow-hidden">
      <div class="absolute inset-0 -z-10 bg-[url('/background-galeri.svg')] bg-cover bg-top bg-no-repeat"></div>
      <div class="absolute inset-0 -z-5 bg-gradient-to-b from-white/0 to-white/100"></div>
      <div class="w-full px-4" data-aos="fade-up" data-aos-delay="500">
        <h2 class="text-3xl font-light text-center text-blue-600 mb-8">Belajar dan Bekerja Bersama dalam Tim</h2>
        <p class="text-center text-gray-600 mb-10 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="400">
          Dalam OSIS, kami belajar merancang, mengelola, dan melaksanakan program kerja secara kolaboratif di bawah bimbingan guru pembina.
        </p>
        <GalleryCarousel :images="galleryImages"/>
      </div>
    </section>

    <!-- Lainnya (Form Aspirasi, Event Besar, Find Us) bisa juga dibuat modular serupa -->
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useEventStore } from '../store/useEventStore'
import { useAOSRefresh } from '../store/useAOSRefresh'

import ProgramCard from '../components/ProgramCard.vue'
import EventCard from '../components/EventCard.vue'
import BidangCard from '../components/BidangCard.vue'
import GalleryCarousel from '../components/GalleryCarousel.vue'

const eventStore = useEventStore()
useAOSRefresh()

onMounted(() => {
  if (!eventStore.events.length && !eventStore.loading) eventStore.fetchEvents()
})

const recentEvents = computed(() => eventStore.events.map(e => ({ ...e, image: e.image || `/images/event-${e.id}.jpg` })).slice(0,2))

const programs = [
  { title: 'Kegiatan Kerohanian', desc: 'Peringatan Hari Besar Islam, Pengajian Rutin, Bakti Sosial, dan Pembinaan Akhlak Mulia.' },
  { title: 'Berbagai Jenis Perlombaan', desc: 'MTQ, Cerdas Cermat Agama, Porseni, dan Kompetisi Sains antar kelas.' },
  { title: 'Nasionalisme & Cinta Tanah Air', desc: 'Upacara Hari Kemerdekaan, Hari Pahlawan, serta kegiatan bela negara berbasis nilai Pancasila.' }
]

const bidangs = [
  { id:1,name:'Bidang I – Kerohanian',desc:'Mengelola kegiatan keagamaan dan pembinaan akhlak.',image:'/images/bidang1.jpg'},
  { id:2,name:'Bidang II – Kesiswaan',desc:'Menangani disiplin, tata tertib, dan pembinaan karakter.',image:'/images/bidang2.jpg'},
  { id:3,name:'Bidang III – Olahraga & Seni',desc:'Mengkoordinir lomba, porseni, dan ekstrakurikuler seni.',image:'/images/bidang3.jpg'},
  { id:4,name:'Bidang IV – Humas & Publikasi',desc:'Mengelola media sosial, dokumentasi, dan hubungan eksternal.',image:'/images/bidang4.jpg'},
  { id:5,name:'Bidang V – Sosial & Lingkungan',desc:'Mengadakan bakti sosial dan kegiatan peduli lingkungan.',image:'/images/bidang5.jpg'},
  { id:6,name:'Bidang VI – Kewirausahaan',desc:'Mendorong kreativitas siswa melalui usaha kecil dan pelatihan.',image:'/images/bidang6.jpg'}
]

const galleryImages = [
  { id:1,title:'Pengajian Rutin Jumat',image:'/images/gallery1' },
  { id:2,title:'Rapat Koordinasi Bidang',image:'/images/gallery2' },
  { id:3,title:'Persiapan Ma’arif Cup',image:'/images/gallery3.jpg' },
  { id:4,title:'Bakti Sosial ke Panti Asuhan',image:'/images/gallery4.jpg' },
  { id:5,title:'Pelatihan Jurnalistik OSIS',image:'/images/gallery5.jpg' }
]
</script>
