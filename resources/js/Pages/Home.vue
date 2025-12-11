<template>
  <div class="min-h-screen w-full bg-transparent overflow-x-hidden overflow-y-hidden"> <!-- Tambahkan overflow-y-hidden -->
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
        <div class="grid gap-8 justify-center 
            grid-cols-1 sm:grid-cols-2 
            md:grid-cols-[repeat(auto-fit,minmax(260px,1fr))] 
            place-items-center">
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
          OSIS MA Ma’arif Udanawu terbagi menjadi 7 bidang untuk fokus menjalankan tugas dan program kerja masing-masing.
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

    <!-- Event Besar -->
    <EventBesarSection />

 
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useEventStore } from '../store/useEventStore'
import { useAOSRefresh } from '../store/useAOSRefresh'

import ProgramCard from '../Pages/ProgramCard.vue'
import EventCard from '../Pages/EventCard.vue'
import BidangCard from '../Pages/BidangCard.vue'
import GalleryCarousel from '../Pages/GalleryCarousel.vue'
import EventBesarSection from '../Pages/EventBesarSection.vue'
import AspirasiSection from '../Pages/AspirasiSection.vue'


const eventStore = useEventStore()
useAOSRefresh()

onMounted(() => {
  if (!eventStore.events.length && !eventStore.loading) eventStore.fetchEvents()
})

const recentEvents = computed(() => eventStore.events.map(e => ({ ...e, image: e.image || `/images/event-${e.id}.jpg` })).slice(0,2))

const programs = [
  { title: 'Classmeeting', desc: 'Kegiatan yang berisi lomba olahraga, seni, dan permainan antar kelas untuk meningkatkan kekompakan.' },
  { title: 'Pemilihan Ketua OSIS', desc: 'Proses demokratis memilih ketua OSIS baru melalui kampanye, debat, dan pemungutan suara.' },
]

const bidangs = [
  { id:1,name:'Bidang I – Badan Pengurus Harian',desc:'Mengatur organisasi dan mengoordinasi seluruh bidang.',image:'../bidang1.jpg'},
  { id:2,name:'Bidang II – Keamanan & Ketertiban',desc:'Menjaga keamanan acara dan ketertiban lingkungan sekolah.',image:'../bidang2.jpg'},
  { id:3,name:'Bidang III – Pramuka & Upacara',desc:'Mengelola kegiatan pramuka dan menyiapkan upacara bendera.',image:'../bidang3.jpg'},
  { id:4,name:'Bidang IV – Keagamaan',desc:'Meningkatkan kegiatan dan wawasan keagamaan.',image:'../bidang4.jpg'},
  { id:5,name:'Bidang V – Kesehatan',desc:'Memberikan pertolongan pertama dan memantau kesehatan siswa.',image:'../bidang5.jpg'},
  { id:6,name:'Bidang VI – Seni & Hubungan Masyarakat',desc:'Menyampaikan informasi & publikasi kegiatan.',image:'../bidang6.jpg'},
  { id:7,name:'Bidang VII – Olahraga',desc:'Meningkatkan minat dan prestasi olahraga.',image:'../bidang7.jpg'}
];


const galleryImages = [
  { id:1,title:'Pengajian Rutin Jumat',image:'/images/gallery1' },
  { id:2,title:'Rapat Koordinasi Bidang',image:'/images/gallery2' },
  { id:3,title:'Persiapan Ma’arif Cup',image:'/images/gallery3.jpg' },
  { id:4,title:'Bakti Sosial ke Panti Asuhan',image:'/images/gallery4.jpg' },
  { id:5,title:'Pelatihan Jurnalistik OSIS',image:'/images/gallery5.jpg' }
]
</script>