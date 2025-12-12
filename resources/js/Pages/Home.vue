<template>
  <div class="min-h-screen w-full bg-transparent overflow-x-hidden">
      <!-- Hero Section -->
      <div
          class="min-h-[70vh] flex flex-col items-center justify-center px-4 text-center relative"
      >
          <div
              class="absolute inset-0 -z-10 bg-[url('/background-header.JPG')] bg-cover bg-center"
          ></div>
          <div
              class="absolute inset-0 -z-5 bg-gradient-to-b from-white/50 to-white/100"
          ></div>
          <div class="max-w-4xl relative z-10">
              <h1
                  class="text-5xl md:text-7xl lg:text-8xl font-light tracking-tight leading-none mb-6"
                  data-aos="fade-down"
                  data-aos-delay="500"
              >
                  <br />OSIS<br />MA MA’ARIF<br />UDANAWU
              </h1>
              <p
                  class="text-lg md:text-xl text-gray-600 mt-8 font-light tracking-wide"
                  data-aos="fade-up"
                  data-aos-delay="500"
              >
                  We may be a<br />
                  <span class="font-medium">leadership</span><br />
                  <span class="font-medium">warehouse</span>
              </p>
              <p
                  class="text-gray-500 mt-12 text-sm uppercase tracking-widest"
                  data-aos="fade-in"
                  data-aos-delay="500"
              >
                  What we’re good at
              </p>
          </div>
      </div>

      <!-- Program Unggulan -->
      <section class="relative py-16">
          <div
              class="absolute inset-0 -z-10 bg-[url('/background-program.svg')] bg-cover bg-top bg-no-repeat"
          ></div>
          <div
              class="absolute inset-0 -z-5 bg-gradient-to-t from-white/30 to-white/100"
          ></div>
          <div class="max-w-6xl mx-auto px-4">
              <div class="text-center mb-16">
                  <h2
                      class="text-4xl font-light text-blue-600"
                      data-aos="fade-left"
                      data-aos-delay="500"
                  >
                      Program Unggulan
                  </h2>
                  <p
                      class="text-gray-600 mt-4 max-w-2xl mx-auto"
                      data-aos="fade-right"
                      data-aos-delay="500"
                  >
                      Yuk, simak kegiatan utama OSIS MA Ma’arif Udanawu!
                  </p>
              </div>
              <div
                  class="grid gap-8 justify-center grid-cols-1 sm:grid-cols-2 md:grid-cols-[repeat(auto-fit,minmax(260px,1fr))] place-items-center"
              >
                  <ProgramCard
                      v-for="(p, i) in programs"
                      :key="i"
                      :title="p.title"
                      :desc="p.desc"
                      :delay="i * 200"
                      :desc-delay="i * 300"
                  />
              </div>
          </div>
      </section>

      <!-- 📝 ARTIKEL (jenis_artikel = "artikel") -->
      <div class="w-full bg-white px-4 py-20">
          <div class="text-center mb-16">
              <h2
                  class="text-4xl font-light text-blue-600"
                  data-aos="fade-left"
                  data-aos-delay="500"
              >
                  Artikel OSIS Terkini
              </h2>
              <p
                  class="text-gray-600 mt-4"
                  data-aos="fade-right"
                  data-aos-delay="500"
              >
                  Yuk, simak cerita kami dalam berbagai kegiatan OSIS!
              </p>
          </div>

          <div
              v-if="eventStore.loading"
              class="text-center py-8 text-gray-500"
          >
              Memuat artikel terbaru...
          </div>
          <div v-else-if="recentArtikels.length" class="space-y-16">
              <EventCard
                  v-for="artikel in recentArtikels"
                  :key="artikel.id"
                  :event="artikel"
                  :delay="artikel.id * 400"
              />
          </div>
          <div
              v-else
              class="text-center py-8 text-gray-500"
              data-aos="fade-up"
              data-aos-delay="500"
          >
              Belum ada artikel terbaru.
          </div>

          <div class="text-center mt-12">
              <router-link
                  to="/artikel"
                  class="inline-block px-6 py-3 text-blue-600 font-medium border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-colors"
                  data-aos="fade-right"
              >
                  Lihat Semua Artikel
              </router-link>
          </div>
      </div>

      <!-- Bidang OSIS -->
      <div class="py-16 relative" data-aos="fade-up" data-aos-delay="500">
          <!-- Loading State untuk Bidang -->
          <div v-if="loadingBidangs" class="text-center py-12">
              <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
              <p class="mt-4 text-gray-600">Memuat bidang-bidang OSIS...</p>
          </div>

          <!-- Error State untuk Bidang -->
          <div v-else-if="errorBidangs" class="bg-red-50 border border-red-200 rounded-lg p-6 text-center mb-6">
              <div class="text-red-600 mb-2">
                  <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
              </div>
              <h3 class="text-lg font-medium text-red-800 mb-2">Gagal memuat data bidang</h3>
              <p class="text-red-700 mb-4">{{ errorBidangs }}</p>
              <button
                  @click="fetchBidangs"
                  class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg"
              >
                  Coba Lagi
              </button>
          </div>

          <!-- Content Bidang -->
          <div v-else>
              <div
                  class="absolute inset-0 -z-10 bg-[url('/background-bidang.svg')] bg-cover bg-top bg-no-repeat"
              >
                  <div
                      class="absolute inset-0 -z-5 bg-gradient-to-b from-transparent to-white/100"
                  ></div>
              </div>
              <div class="max-w-6xl mx-auto px-4 text-center">
                  <h2 class="text-3xl font-light text-white mb-4">BIDANG</h2>
                  <p class="text-white mb-12 max-w-3xl mx-auto">
                      OSIS MA Ma’arif Udanawu terbagi menjadi 7 bidang untuk fokus
                      menjalankan tugas dan program kerja masing-masing.
                  </p>
                  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                      <BidangCard
                          v-for="b in bidangs"
                          :key="b.id"
                          :bidang="b"
                          :delay="b.id * 200"
                      />
                  </div>
              </div>
          </div>
      </div>

      <!-- Galeri Mini
      <section class="relative py-16 overflow-hidden">
          <div
              class="absolute inset-0 -z-10 bg-[url('/background-galeri.svg')] bg-cover bg-top bg-no-repeat"
          ></div>
          <div
              class="absolute inset-0 -z-5 bg-gradient-to-b from-white/0 to-white/100"
          ></div>
          <div class="w-full px-4" data-aos="fade-up" data-aos-delay="500">
              <h2 class="text-3xl font-light text-center text-blue-600 mb-8">
                  Belajar dan Bekerja Bersama dalam Tim
              </h2>
              <p
                  class="text-center text-gray-600 mb-10 max-w-3xl mx-auto"
                  data-aos="fade-up"
                  data-aos-delay="400"
              >
                  Dalam OSIS, kami belajar merancang, mengelola, dan
                  melaksanakan program kerja secara kolaboratif di bawah
                  bimbingan guru pembina.
              </p>
              <GalleryCarousel :images="galleryImages" />
          </div>
      </section> -->

      <EventBesarSection :events="recentEvents" />
       <div class="text-center mt-12">
              <router-link
                  to="/artikel"
                  class="inline-block px-6 py-3 text-blue-600 font-medium border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-colors"
                  data-aos="fade-right"
              >
                  Lihat Semua Artikel
              </router-link>
          </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useEventStore } from "../store/useEventStore";
import { useAOSRefresh } from "../store/useAOSRefresh";
import axios from 'axios'; // Import axios

import ProgramCard from "../Pages/ProgramCard.vue";
import EventCard from "../Pages/EventCard.vue";
import BidangCard from "../Pages/BidangCard.vue"; // Pastikan BidangCard juga siap menerima data dari API
import GalleryCarousel from "../Pages/GalleryCarousel.vue";
import EventBesarSection from "../Pages/EventBesarSection.vue";

const eventStore = useEventStore();
useAOSRefresh();

// State untuk data bidang dari API
const bidangs = ref([]); // Ubah dari array statis ke reactive ref
const loadingBidangs = ref(true); // Tambahkan state loading
const errorBidangs = ref(null); // Tambahkan state error

// Ambil data bidang dari API
const fetchBidangs = async () => {
  loadingBidangs.value = true;
  errorBidangs.value = null;
  try {
      // Ganti dengan endpoint API Laravel Anda
      const response = await axios.get('/bidang');
      bidangs.value = response.data.data; // Asumsikan struktur data API adalah { data: [...] }
      console.log('Data bidang dari API:', bidangs.value);
  } catch (err) {
      console.error('Error fetching bidangs:', err);
      errorBidangs.value = err.response?.data?.message || 'Gagal memuat data bidang dari server.';
  } finally {
      loadingBidangs.value = false;
  }
};

onMounted(async () => {
  // Ambil data event (jika belum dilakukan)
  if (!eventStore.events.length && !eventStore.loading) {
      eventStore.fetchEvents();
  }
  // Ambil data bidang
  await fetchBidangs();
});

// ✅ Filter artikel biasa
const recentArtikels = computed(() =>
  eventStore.events
      .filter((item) => item.jenis_artikel === "artikel")
      .slice(0, 2)
);

// ✅ Filter event besar
const recentEvents = computed(() =>
  eventStore.events
      .filter((item) => item.jenis_artikel === "event")
      .slice(0, 2)
);

const programs = [
  {
      title: "Classmeeting",
      desc: "Kegiatan yang berisi lomba olahraga, seni, dan permainan antar kelas untuk meningkatkan kekompakan.",
  },
  {
      title: "Pemilihan Ketua OSIS",
      desc: "Proses demokratis memilih ketua OSIS baru melalui kampanye, debat, dan pemungutan suara.",
  },
];

//const galleryImages = [
//{ id:1,title:'Pengajian Rutin Jumat',image:'/images/gallery1' },
//{ id:2,title:'Rapat Koordinasi Bidang',image:'/images/gallery2' },
//{ id:3,title:'Persiapan Ma’arif Cup',image:'/images/gallery3.jpg' },
//{ id:4,title:'Bakti Sosial ke Panti Asuhan',image:'/images/gallery4.jpg' },
//{ id:5,title:'Pelatihan Jurnalistik OSIS',image:'/images/gallery5.jpg' }
//]
</script>