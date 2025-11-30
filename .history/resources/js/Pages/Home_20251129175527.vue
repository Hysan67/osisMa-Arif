<!-- src/pages/Home.vue -->
<template>
  <div class="min-h-screen w-full bg-transparant overflow-x-hidden">
    <!-- Hero Section (ala lightfactorynow.com) -->
    <div class="min-h-[70vh] flex flex-col items-center justify-center px-4 text-center relative">
      <!-- Background Image -->
  <div class="absolute inset-0 -z-10 bg-[url('/background-header.JPG')] bg-cover bg-center"></div>
  <!-- Gradient Overlay -->
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
      <div class="text-center mb-16" data-aos="fade-down" data-aos-delay="500">
        <h2 class="text-4xl font-light text-blue-600">Program Unggulan</h2>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
          Yuk, simak kegiatan utama OSIS MA Ma’arif Udanawu!
        </p>
      </div>
      <div class="grid md:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="800">
        <div v-for="(item, i) in programs" :key="i" class="text-center group">
          <div class="mb-4">
            <div class="w-12 h-px bg-blue-600 mx-auto group-hover:w-16 transition-all"></div>
          </div>
          <h3 class="text-xl font-medium text-blue-600 mb-3">{{ item.title }}</h3>
          <p class="text-gray-700">{{ item.desc }}</p>
        </div>
      </div>
      </div>
    </section>

    <!-- Event Terkini -->
    <div class="w-full bg-white px-4 py-20" data-aos="fade-up" data-aos-delay="500">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-light text-blue-600">Event OSIS Terkini</h2>
        <p class="text-gray-600 mt-4">Yuk, simak cerita kami dalam berbagai kegiatan OSIS!</p>
      </div>

      <div v-if="eventStore.loading" class="text-center py-8 text-gray-500">Memuat event terbaru...</div>

      <div v-else-if="recentEvents.length" class="space-y-16">
        <router-link
          v-for="event in recentEvents"
          :key="event.id"
          :to="`/event/${event.id}`"
          class="block group"
          data-aos="fade-up"
          :data-aos-delay="event.id * 400"
        >
          <div class="md:flex gap-8 items-center">
            <div class="md:w-1/2 mb-6 md:mb-0">
              <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden shadow-md group-hover:shadow-xl transition-all duration-500">
                <img 
                :src="event.image || '/placeholder-event.jpg'" 
                :alt="event.title"
                class="w-full h-full object-cover transition-all duration-500 
                      group-hover:scale-105 group-hover:brightness-90"
              />
              </div>
            </div>
            <div class="md:w-1/2 text-center md:text-left">
              <h3 class="text-2xl font-light text-blue-600 mb-2">{{ event.title }}</h3>
              <p class="text-sm text-gray-500 mb-4">{{ event.date }}</p>
              <p class="text-gray-700 max-w-2xl mx-auto md:mx-0">{{ event.desc }}</p>
            </div>
          </div>
        </router-link>
      </div>

      <div v-else class="text-center py-8 text-gray-500" data-aos="fade-up" data-aos-delay="500">Belum ada event terbaru.</div>

      <div class="text-center mt-12">
        <router-link
          to="/event"
          class="inline-block px-6 py-3 text-blue-600 font-medium border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-colors" data-aos="fade-right"
        >
          Lihat Semua Event
        </router-link>
      </div>
    </div>

    <!-- Bidang OSIS -->
    <div class="py-16 relative" data-aos="fade-up" data-aos-delay="500">
      <div
        class="absolute inset-0 -z-10 bg-[url('/background-bidang.svg')] bg-cover bg-top bg-no-repeat">
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 -z-5 bg-gradient-to-b from-transparent to-white/100"></div>
        <div class="absolute inset-0 bg-black/0"></div>
      </div>
      <div class="max-w-6xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-light text-white mb-4">BIDANG</h2>
        <p class="text-white mb-12 max-w-3xl mx-auto">
          OSIS MA Ma’arif Udanawu terbagi menjadi 6 bidang untuk fokus menjalankan tugas dan program kerja masing-masing.
        </p>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <router-link
            v-for="bidang in bidangs"
            :key="bidang.id"
            :to="`/bidang/${bidang.id}`"
            class="group block rounded-xl overflow-hidden shadow-lg 
                hover:shadow-2xl transition-all duration-500 
                transform hover:-translate-y-2"
            data-aos="fade-up"
            :data-aos-delay="bidang.id * 200"
            >
            <!-- Foto sebagai background -->
            <div class="relative">
              <!-- Gambar -->
              <img 
                :src="bidang.image" 
                :alt="bidang.name"
                class="w-full h-56 object-cover transition-transform duration-700 
                      group-hover:scale-110"
                data-aos="fade-up"
                :data-aos-delay="bidang.id * 200"
              />
              <!-- Overlay gelap agar teks terbaca -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent transition-all duration-500 group-hover:from-black/80"></div>
              <!-- Teks di atas foto -->
              <div class="absolute bottom-0 left-0 right-0 p-5 text-white z-10 text-left">
                <h3 class="font-bold text-lg">{{ bidang.name }}</h3>
                <p class="text-sm opacity-90 mt-1">{{ bidang.desc }}</p>
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>

    <!-- Pesan Ketua OSIS -->
    <section class="relative py-16 overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-[url('/background-pesank.svg')] bg-cover bg-top md:bg-center bg-left bg-no-repeat"></div>
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 -z-5 bg-gradient-to-t from-white/50 to-white/100"></div>
    <div class="max-w-5xl mx-auto px-4 py-20" data-aos="fade-in" data-aos-delay="500">
      <div class="md:flex items-start gap-10">
        <div class="md:w-2/5 mb-8 md:mb-0 flex justify-center">
          <div class="relative">
            <img
              src=""
              alt="Ahmad Fauzi - Ketua OSIS"
              class="w-48 h-48 rounded-full object-cover border-4 border-white shadow-sm"
              data-aos="fade-right"
              :data-aos-delay="800"
            />
            <div class="absolute inset-0 rounded-full border-2 border-yellow-300 border-opacity-50 pointer-events-none"></div>
          </div>
        </div>
        <div class="md:w-3/5">
          <div class="mb-4">
            <div class="w-12 h-px bg-yellow-300"></div>
          </div>
          <blockquote class="text-gray-800 text-xl md:text-2xl font-light italic leading-relaxed mb-6" data-aos="fade-left" data-aos-delay="500">
            “Saya berharap OSIS MA Ma’arif Udanawu menjadi wadah bagi siswa-siswi untuk mengembangkan potensi diri, membangun karakter islami, dan mewujudkan semangat kepemimpinan yang berakhlak mulia.”
          </blockquote>
          <div>
            <p class="font-medium text-blue-600 text-lg" data-aos="fade-right" data-aos-delay="500">Ahmad Fauzi</p>
            <p class="text-gray-600" data-aos="fade-left" data-aos-delay="500">Ketua OSIS Periode 2024/2025</p>
          </div>
        </div>
      </div>
    </div>
    </section>

   <!-- Galeri Kegiatan (Mini) -->
    <section class="relative py-16 overflow-hidden">
      <div class="absolute inset-0 -z-10 bg-[url('/background-galeri.svg')] bg-cover bg-top bg-no-repeat"></div>
      <!-- Gradient Overlay -->
      <div class="absolute inset-0 -z-5 bg-gradient-to-b from-white/0 to-white/100"></div>
      <div class="w-full px-4" data-aos="fade-up" data-aos-delay="500">
        <h2 class="text-3xl font-light text-center text-blue-600 mb-8">Belajar dan Bekerja Bersama dalam Tim</h2>
        <p class="text-center text-gray-600 mb-10 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="400">
          Dalam OSIS, kami belajar merancang, mengelola, dan melaksanakan program kerja secara kolaboratif di bawah bimbingan guru pembina.
        </p>

        <!-- Carousel Container -->
        <div class="relative max-w-4xl mx-auto" data-aos="flip-left" data-aos-delay="700">
          <!-- Foto Saat Ini -->
          <div class="bg-gray-200 aspect-video rounded-xl flex items-center justify-center overflow-hidden" data-aos="fade-up" data-aos-delay="400">
            <!-- Ganti dengan <img> saat ada aset -->
            <span class="text-gray-600 text-lg">Foto: {{ galleryImages[currentIndex].title }}</span>
          </div>

          <!-- Panah Navigasi -->
          <button
            @click="prevImage"
            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 hover:bg-opacity-100 rounded-full p-2 shadow-md"
            aria-label="Foto sebelumnya"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button
            @click="nextImage"
            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 hover:bg-opacity-100 rounded-full p-2 shadow-md"
            aria-label="Foto berikutnya"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>

          <!-- Indikator (dots) -->
          <div class="flex justify-center mt-4 space-x-2">
            <button
              v-for="(img, index) in galleryImages"
              :key="index"
              @click="goToImage(index)"
              class="w-3 h-3 rounded-full"
              :class="index === currentIndex ? 'bg-blue-600' : 'bg-gray-400'"
              :aria-label="`Lihat foto ${index + 1}`"
            ></button>
          </div>
        </div>
      </div>
    </section>

    <!-- Event Besar -->
    <div class="bg-transparant py-20">
      <div class="max-w-6xl mx-auto px-4" data-aos="fade-up" data-aos-delay="500">
        <h2 class="text-4xl font-light text-center text-blue-600 mb-16">Event Besar Kami</h2>

        <div class="space-y-20">
          <!-- Ma’arif Cup -->
          <div class="md:flex items-center gap-8" data-aos="fade-right" data-aos-delay="400">
            <div class="md:w-1/2 mb-6 md:mb-0">
              <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden">
                <img 
                  src="" 
                  alt="MA’ARIF CUP"
                  class="w-full h-full object-cover bg-gradient-to-t from-black/50 to-transparent"
                />
              </div>
            </div>
            <div class="md:w-1/2 text-center md:text-left">
              <h3 class="text-2xl font-light text-blue-600 mb-4">MA’ARIF CUP</h3>
              <p class="text-gray-700">
                Perlombaan antar sekolah tingkat Kabupaten Blitar yang mencakup cabang olahraga seperti futsal, voli, dan bulutangkis.
              </p>
            </div>
          </div>

          <!-- Ma’arif Competition -->
          <div class="md:flex flex-row-reverse items-center gap-8" data-aos="fade-left" data-aos-delay="400">
            <div class="md:w-1/2 mb-6 md:mb-0">
              <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden">
                <img 
                  src="" 
                  alt="MA’ARIF COMPETITION"
                  class="w-full h-full object-cover bg-gradient-to-t from-black/50 to-transparent"
                />
              </div>
            </div>
            <div class="md:w-1/2 text-center md:text-left">
              <h3 class="text-2xl font-light text-blue-600 mb-4">MA’ARIF COMPETITION</h3>
              <p class="text-gray-700">
                Kompetisi akademik tingkat MTs/SMP dan MA/SMA/SMK se-Jawa Timur, mencakup lomba MTQ, Pidato Bahasa Arab, dan Cerdas Cermat Keagamaan.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

        <!-- Form Aspirasi Siswa -->
    <div class="max-w-6xl mx-auto px-4 bg-gradient-to-t from-transparant-40 to-blue-600 py-10">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-light text-blue-600" data-aos="fade-right" data-aos-delay="400">Form Aspirasi Siswa</h2>
        <p class="text-gray-600 mt-4" data-aos="fade-left" data-aos-delay="400">Yuk, sampaikan aspirasi kalian!</p>
      </div>

      <div v-if="eventStore.loading" class="text-center py-8 text-gray-500">Memuat form...</div>
      <div class="text-center mt-12">
        <router-link
          to="/form-aspirasi-siswa"
          class="inline-block px-6 py-3 text-blue-600 font-medium border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-colors" data-aos="fade-right"
        >
          Mulai Mengisi Form
        </router-link>
      </div>
    </div>


    <!-- Find Us -->
    <div class="relative bg-gradient-to-t from-blue-600 to-transparant-40 text-white py-24 px-4 overflow-x-hidden w-full" >
      <div class="absolute top-10 left-10 w-32 h-32 rounded-full bg-yellow-300 bg-opacity-10 blur-xl pointer-events-none"></div>
      <div class="absolute bottom-20 right-10 w-40 h-40 rounded-full bg-white bg-opacity-5 blur-2xl pointer-events-none"></div>
      <div class="max-w-4xl mx-auto text-center relative z-10" data-aos="flip-right" data-aos-delay="400">
        <div class="mb-6">
          <div class="w-16 h-1 bg-yellow-300 mx-auto rounded-full"></div>
        </div>
        <h2 class="text-3xl md:text-4xl font-light mb-4">Temukan Kami</h2>
        <p class="opacity-90 max-w-2xl mx-auto mb-12">
          Ikuti setiap langkah, karya, dan kegiatan OSIS MA Ma’arif Udanawu melalui platform berikut.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-2xl mx-auto">
          <!-- Instagram -->
          <a
            href="https://instagram.com/osismaudanawu"
            target="_blank"
            rel="noopener noreferrer"
            class="group block p-6 rounded-3xl bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-10 hover:bg-opacity-20 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
            aria-label="Ikuti kami di Instagram"
          >
            <div class="flex justify-center mb-4">
              <div class="w-14 h-14 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 fill-white" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
              </div>
            </div>
            <h3 class="font-semibold text-lg">Instagram</h3>
            <p class="text-sm opacity-80 mt-1">@osismaudanawu</p>
          </a>

          <!-- YouTube -->
          <a
            href="https://youtube.com/@osismaudanawu"
            target="_blank"
            rel="noopener noreferrer"
            class="group block p-6 rounded-3xl bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-10 hover:bg-opacity-20 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
            aria-label="Tonton di YouTube"
          >
            <div class="flex justify-center mb-4">
              <div class="w-14 h-14 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 fill-white" viewBox="0 0 24 24">
                  <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                </svg>
              </div>
            </div>
            <h3 class="font-semibold text-lg">YouTube</h3>
            <p class="text-sm opacity-80 mt-1">Video Kegiatan</p>
          </a>

          <!-- WhatsApp -->
          <a
            href="https://wa.me/6281234567890"
            target="_blank"
            rel="noopener noreferrer"
            class="group block p-6 rounded-3xl bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-10 hover:bg-opacity-20 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
            aria-label="Hubungi via WhatsApp"
          >
            <div class="flex justify-center mb-4">
              <div class="w-14 h-14 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 fill-white" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
              </div>
            </div>
            <h3 class="font-semibold text-lg">WhatsApp</h3>
            <p class="text-sm opacity-80 mt-1">Info & Konfirmasi</p>
          </a>
        </div>

        <p class="mt-10 text-sm opacity-70">
          Kami selalu terbuka untuk kolaborasi, saran, atau pertanyaan!
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onUnmounted, computed, ref } from 'vue'
import { useEventStore } from '../store/useEventStore'
import { useAOSRefresh } from '../store/useAOSRefresh'

const eventStore = useEventStore()
useAOSRefresh() // auto refresh saat mount/update

onMounted(() => {
  if (!eventStore.events.length && !eventStore.loading) {
    eventStore.fetchEvents()
  }
  useAOSRefresh() // refresh ulang animasi
})

const recentEvents = computed(() => {
  return eventStore.events.map(event => ({
    ...event,
    image: event.image || `/images/event-${event.id}.jpg`
  })).slice(0, 2)
})

// Program Unggulan
const programs = [
  {
    title: 'Kegiatan Kerohanian',
    desc: 'Peringatan Hari Besar Islam, Pengajian Rutin, Bakti Sosial, dan Pembinaan Akhlak Mulia.'
  },
  {
    title: 'Berbagai Jenis Perlombaan',
    desc: 'MTQ, Cerdas Cermat Agama, Porseni, dan Kompetisi Sains antar kelas.'
  },
  {
    title: 'Nasionalisme & Cinta Tanah Air',
    desc: 'Upacara Hari Kemerdekaan, Hari Pahlawan, serta kegiatan bela negara berbasis nilai Pancasila.'
  }
]

// Bidang
const bidangs = [
  { id: 1, name: 'Bidang I – Kerohanian', desc: 'Mengelola kegiatan keagamaan dan pembinaan akhlak.', image: '/images/bidang1.jpg' },
  { id: 2, name: 'Bidang II – Kesiswaan', desc: 'Menangani disiplin, tata tertib, dan pembinaan karakter.', image: '/images/bidang2.jpg' },
  { id: 3, name: 'Bidang III – Olahraga & Seni', desc: 'Mengkoordinir lomba, porseni, dan ekstrakurikuler seni.', image: '/images/bidang3.jpg' },
  { id: 4, name: 'Bidang IV – Humas & Publikasi', desc: 'Mengelola media sosial, dokumentasi, dan hubungan eksternal.', image: '/images/bidang4.jpg' },
  { id: 5, name: 'Bidang V – Sosial & Lingkungan', desc: 'Mengadakan bakti sosial dan kegiatan peduli lingkungan.', image: '/images/bidang5.jpg' },
  { id: 6, name: 'Bidang VI – Kewirausahaan', desc: 'Mendorong kreativitas siswa melalui usaha kecil dan pelatihan.', image: '/images/bidang6.jpg' }
]

// Galeri (pastikan file gambar ada di /public/images/)
const galleryImages = [
  { id: 1, title: 'Pengajian Rutin Jumat', image: '/images/gallery1' },
  { id: 2, title: 'Rapat Koordinasi Bidang', image: '/images/gallery2' },
  { id: 3, title: 'Persiapan Ma’arif Cup', image: '/images/gallery3.jpg' },
  { id: 4, title: 'Bakti Sosial ke Panti Asuhan', image: '/images/gallery4.jpg' },
  { id: 5, title: 'Pelatihan Jurnalistik OSIS', image: '/images/gallery5.jpg' }
]

const currentIndex = ref(0)

const prevImage = () => {
  currentIndex.value = (currentIndex.value - 1 + galleryImages.length) % galleryImages.length
}
const nextImage = () => {
  currentIndex.value = (currentIndex.value + 1) % galleryImages.length
}
const goToImage = (index) => {
  currentIndex.value = index
}

// Auto-slide (opsional, bisa dihapus jika tidak diinginkan)
let interval
onMounted(() => {
  interval = setInterval(nextImage, 6000)
})
onUnmounted(() => {
  clearInterval(interval)
})

// Social Links
const socialLinks = [
  { name: 'Instagram', handle: '@osismaudanawu', url: 'https://instagram.com/osismaudanawu' },
  { name: 'YouTube', handle: 'Video Kegiatan', url: 'https://youtube.com/@osismaudanawu' },
  { name: 'WhatsApp', handle: 'Info & Konfirmasi', url: 'https://wa.me/6281234567890' }
]
// --- Animasi Scroll Manual ---
const animatedElements = ref([])

const animateOnScroll = () => {
  animatedElements.value.forEach((el) => {
    if (!el) return
    const rect = el.getBoundingClientRect()
    const isVisible = rect.top < window.innerHeight - 100

    if (isVisible && !el.classList.contains('animated')) {
      el.classList.add('opacity-0', 'translate-y-6', 'transition-all', 'duration-700', 'ease-out')
      // Trigger repaint
      void el.offsetWidth
      el.classList.remove('opacity-0', 'translate-y-6')
      el.classList.add('opacity-100', 'translate-y-0', 'animated')
    }
  })
}

onMounted(() => {
  window.addEventListener('scroll', animateOnScroll)
  // Jalankan sekali saat load
  setTimeout(animateOnScroll, 300)
})

onUnmounted(() => {
  window.removeEventListener('scroll', animateOnScroll)
})
</script>