<template>
    <div class="min-h-screen w-full bg-transparent overflow-x-hidden" :class="{ 'overflow-hidden': showAnnouncementModal }">
      <!-- Modal Pengumuman (Updated Design) -->
      <div v-if="showAnnouncementModal && activeAnnouncements.length" 
           class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
        <!-- Overlay dengan blur lebih halus -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeAnnouncementModal"></div>
        
        <!-- Modal Content - Desain Biru dengan Gambar Kotak -->
        <div class="relative bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[85vh] overflow-hidden animate-scale-in modal-scrollbar border border-blue-100">
          <!-- Header Biru -->
          <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5 flex items-center justify-between border-b border-blue-500 z-10">
            <div class="flex items-center gap-3">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
              </svg>
              <div>
                <h2 class="text-2xl font-bold text-white">PENGUMUMAN PENTING</h2>
                <p class="text-blue-100 text-sm mt-1">OSIS MA Ma'arif Udanawu</p>
              </div>
            </div>
            
            <!-- Counter -->
            <div class="flex items-center gap-2 bg-blue-800/30 px-4 py-2 rounded-full border border-blue-400/50">
              <span class="text-white font-bold text-lg">{{ currentAnnouncementIndex + 1 }}</span>
              <span class="text-blue-200">/</span>
              <span class="text-white">{{ activeAnnouncements.length }}</span>
            </div>
          </div>
          
          <!-- Carousel Content dengan Layout yang Lebih Baik -->
          <div class="p-6 overflow-y-auto max-h-[calc(85vh-140px)]">
            <div v-for="(announcement, index) in activeAnnouncements" 
                 :key="announcement.id"
                 v-show="currentAnnouncementIndex === index"
                 class="space-y-6">
              
              <!-- Gambar Kotak dengan Aspect Ratio 1:1 -->
              <div v-if="announcement.img" class="relative">
                <div class="flex justify-center">
                  <img :src="getImageUrl(announcement.img)" 
                       :alt="announcement.judul"
                       class="w-full max-w-md h-64 object-cover rounded-lg shadow-lg border-4 border-white"
                       @error="handleImageError" />
                </div>
                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full"></div>
              </div>
              
              <!-- Judul di bawah gambar (jika ada gambar) atau di atas (jika tidak) -->
              <div :class="{'mt-8': !announcement.img, 'mt-6': announcement.img}">
                <h3 class="text-3xl font-bold text-gray-900 text-center">{{ announcement.judul }}</h3>
                
                <!-- Garis pemisah -->
                <div class="flex items-center justify-center my-4">
                  <div class="w-16 h-1 bg-blue-500 rounded-full"></div>
                  <div class="mx-4">
                    <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                  <div class="w-16 h-1 bg-blue-500 rounded-full"></div>
                </div>
              </div>
              
              <!-- Deskripsi -->
              <div class="prose prose-lg max-w-none text-gray-700 bg-blue-50/50 p-6 rounded-xl border border-blue-100" v-html="announcement.deskripsi"></div>
              
              <!-- Info Waktu dengan Desain Card -->
              <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Tanggal Berakhir (jika ada) -->
                  <div v-if="announcement.expires_at" class="flex items-center gap-4 p-4 bg-white rounded-lg border border-blue-100">
                    <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                      <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </div>
                    <div>
                      <p class="text-sm text-red-600 font-semibold uppercase tracking-wider">Berakhir</p>
                      <p class="font-medium text-gray-800 mt-1">{{ formatDate(announcement.expires_at) }}</p>
                      <p class="text-xs text-red-500 mt-1 font-medium" v-if="isExpiringSoon(announcement.expires_at)">
                        ⚠️ Akan segera berakhir
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Footer dengan Navigasi yang Lebih Rapi -->
          <div class="sticky bottom-0 bg-white border-t border-blue-200 px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Navigation Dots -->
            <div class="flex gap-3">
              <button 
                v-for="(_, index) in activeAnnouncements" 
                :key="index"
                @click="currentAnnouncementIndex = index"
                class="w-8 h-2 rounded-full transition-all duration-300 relative group"
                :class="currentAnnouncementIndex === index ? 'bg-blue-600' : 'bg-blue-300 hover:bg-blue-400'"
                :title="`Pengumuman ${index + 1}`"
              >
                <span v-if="currentAnnouncementIndex === index" class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-bold text-blue-700 bg-white px-2 py-1 rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
                  {{ index + 1 }}
                </span>
              </button>
            </div>
            
            <!-- Navigation Buttons & Close -->
            <div class="flex items-center gap-4">
              <!-- Navigation Arrows -->
              <div class="flex items-center gap-3 bg-blue-50 p-2 rounded-xl">
                <button 
                  @click="prevAnnouncement"
                  :disabled="currentAnnouncementIndex === 0"
                  class="w-10 h-10 rounded-full bg-white border-2 border-blue-200 hover:bg-blue-50 hover:border-blue-400 disabled:opacity-30 disabled:cursor-not-allowed transition-all flex items-center justify-center shadow-sm"
                  title="Sebelumnya"
                >
                  <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                  </svg>
                </button>
                
                <span class="text-blue-700 font-medium text-sm">
                  {{ currentAnnouncementIndex + 1 }} / {{ activeAnnouncements.length }}
                </span>
                
                <button 
                  @click="nextAnnouncement"
                  :disabled="currentAnnouncementIndex === activeAnnouncements.length - 1"
                  class="w-10 h-10 rounded-full bg-white border-2 border-blue-200 hover:bg-blue-50 hover:border-blue-400 disabled:opacity-30 disabled:cursor-not-allowed transition-all flex items-center justify-center shadow-sm"
                  title="Berikutnya"
                >
                  <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                  </svg>
                </button>
              </div>
              
              <!-- Close Button -->
              <button 
                @click="closeAnnouncementModal"
                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl flex items-center gap-3 group"
              >
                <svg class="w-5 h-5 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="relative">
                  Saya Sudah Membaca
                  <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Konten Utama (blur ketika ada pengumuman) -->
      <div :class="{ 'blur-sm pointer-events-none': showAnnouncementModal && activeAnnouncements.length }">
        <!-- Hero Section -->
        <div class="min-h-[70vh] flex flex-col items-center justify-center px-4 text-center relative">
          <div class="absolute inset-0 -z-10 bg-[url('/background-header1.jpg')] bg-cover bg-center"></div>
          <div class="absolute inset-0 -z-5 bg-gradient-to-b from-white/50 to-white/100"></div>
          <div class="max-w-4xl relative z-10">
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-light tracking-tight leading-none mb-6"
                data-aos="fade-down" data-aos-delay="500">
              <br />OSIS<br />MA MA'ARIF<br />UDANAWU
            </h1>
            <p class="text-lg md:text-xl text-gray-600 mt-8 font-light tracking-wide"
               data-aos="fade-up" data-aos-delay="500">
              We may be a<br />
              <span class="font-medium">leadership</span><br />
              <span class="font-medium">warehouse</span>
            </p>
            <p class="text-gray-500 mt-12 text-sm uppercase tracking-widest"
               data-aos="fade-in" data-aos-delay="500">
              What we're good at
            </p>
          </div>
        </div>
  
        <!-- Program Unggulan -->
        <section class="relative py-16">
          <div class="absolute inset-0 -z-10 bg-[url('/background-program.svg')] bg-cover bg-top bg-no-repeat"></div>
          <div class="absolute inset-0 -z-5 bg-gradient-to-t from-white/30 to-white/100"></div>
          <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
              <h2 class="text-4xl font-light text-blue-600"
                  data-aos="fade-left" data-aos-delay="500">
                Program Unggulan
              </h2>
              <p class="text-gray-600 mt-4 max-w-2xl mx-auto"
                 data-aos="fade-right" data-aos-delay="500">
                Yuk, simak kegiatan utama OSIS MA Ma'arif Udanawu!
              </p>
            </div>
            <div class="grid gap-8 justify-center grid-cols-1 sm:grid-cols-2 md:grid-cols-[repeat(auto-fit,minmax(260px,1fr))] place-items-center">
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
            <h2 class="text-4xl font-light text-blue-600"
                data-aos="fade-left" data-aos-delay="500">
              Artikel OSIS Terkini
            </h2>
            <p class="text-gray-600 mt-4"
               data-aos="fade-right" data-aos-delay="500">
              Yuk, simak cerita kami dalam berbagai kegiatan OSIS!
            </p>
          </div>
  
          <div v-if="eventStore.loading" class="text-center py-8 text-gray-500">
            Memuat artikel terbaru...
          </div>
          <div v-else-if="recentArtikels.length" class="space-y-16">
            <EventCard
              v-for="artikel in recentArtikels"
              :key="artikel.id"
              :event="artikel"
              :delay="artikel.id"
            />
          </div>
          <div v-else class="text-center py-8 text-gray-500"
               data-aos="fade-up" data-aos-delay="500">
            Belum ada artikel terbaru.
          </div>
  
          <div class="text-center mt-12">
            <router-link to="/event-artikel"
                         class="inline-block px-6 py-3 text-blue-600 font-medium border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-colors"
                         data-aos="fade-right">
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
            <button @click="fetchBidangs"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
              Coba Lagi
            </button>
          </div>
  
          <!-- Content Bidang -->
          <div v-else>
            <div class="absolute inset-0 -z-10 bg-[url('/background-bidang.svg')] bg-cover bg-top bg-no-repeat">
              <div class="absolute inset-0 -z-5 bg-gradient-to-b from-transparent to-white/100"></div>
            </div>
            <div class="max-w-6xl mx-auto px-4 text-center">
              <h2 class="text-3xl font-light text-white mb-4">BIDANG</h2>
              <p class="text-white mb-12 max-w-3xl mx-auto">
                OSIS MA Ma'arif Udanawu terbagi menjadi 7 bidang untuk fokus
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
  
        <EventBesarSection :events="recentEvents" />
        <div class="text-center mt-12">
          <router-link to="/event-artikel"
                       class="inline-block px-6 py-3 text-blue-600 font-medium border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-colors"
                       data-aos="fade-right">
            Lihat Semua Artikel
          </router-link>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted, onBeforeUnmount, watch } from "vue";
  import { useEventStore } from "../store/useEventStore";
  import { useAOSRefresh } from "../store/useAOSRefresh";
  import axios from 'axios';
  
  import ProgramCard from "../Pages/ProgramCard.vue";
  import EventCard from "../Pages/EventCard.vue";
  import BidangCard from "../Pages/BidangCard.vue";
  import GalleryCarousel from "../Pages/GalleryCarousel.vue";
  import EventBesarSection from "../Pages/EventBesarSection.vue";
  
  const eventStore = useEventStore();
  useAOSRefresh();
  
  // State untuk data bidang dari API
  const bidangs = ref([]);
  const loadingBidangs = ref(true);
  const errorBidangs = ref(null);
  
  // State untuk pengumuman
  const activeAnnouncements = ref([]);
  const currentAnnouncementIndex = ref(0);
  const showAnnouncementModal = ref(false);
  const hasSeenAnnouncements = ref(false);
  
  // Ambil data bidang dari API
  const fetchBidangs = async () => {
    loadingBidangs.value = true;
    errorBidangs.value = null;
    try {
      const response = await axios.get('/bidang');
      bidangs.value = response.data.data || response.data;
    } catch (err) {
      console.error('Error fetching bidangs:', err);
      errorBidangs.value = err.response?.data?.message || 'Gagal memuat data bidang dari server.';
    } finally {
      loadingBidangs.value = false;
    }
  };
  
  // Fungsi untuk mendapatkan URL gambar
  const getImageUrl = (imgPath) => {
    if (!imgPath) return '';
    if (imgPath.startsWith('http') || imgPath.startsWith('data:')) return imgPath;
    if (imgPath.startsWith('public/')) imgPath = imgPath.replace('public/', '');
    if (imgPath.startsWith('/')) imgPath = imgPath.substring(1);
    return `/storage/${imgPath}`;
  };

  const handleImageError = (event) => {
    console.error('❌ Image failed to load:', event.target.src);
    event.target.style.display = 'none';
    
    // Tampilkan placeholder
    const parent = event.target.parentElement;
    const placeholder = document.createElement('div');
    placeholder.className = 'w-full max-w-md h-64 flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg border-4 border-white';
    placeholder.innerHTML = `
        <div class="text-center">
        <svg class="w-16 h-16 text-blue-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-blue-600 font-medium">Gambar tidak tersedia</p>
        </div>
    `;
    parent.replaceChild(placeholder, event.target);
    };
  
  // Fetch pengumuman aktif
  const fetchActiveAnnouncements = async () => {
    try {
        console.log('=== FETCH ACTIVE ANNOUNCEMENTS START ===');
        
        const response = await axios.get('/announcements/active');
        console.log('Full response:', response);
        console.log('response.data:', response.data);
        console.log('response.data.data:', response.data.data);
        
        // FORMAT YANG BENAR
        const announcements = Array.isArray(response.data.data) ? response.data.data : [];
        
        console.log('Announcements array:', announcements);
        console.log('Announcements count:', announcements.length);
        
        if (announcements.length === 0) {
        console.log('No announcements found');
        return;
        }
        
        // SIMPLE TEST: Tampilkan SEMUA tanpa filter
        console.log('🎯 FORCE SHOWING MODAL FOR TESTING');
        activeAnnouncements.value = announcements;
        showAnnouncementModal.value = true;
        document.body.style.overflow = 'hidden';
        
        console.log('Modal should be visible now!');
        
    } catch (error) {
        console.error('❌ Error:', error);
        if (error.response) {
        console.error('Status:', error.response.status);
        console.error('Response:', error.response.data);
        }
    }
    };
  
    const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    };

    const isExpiringSoon = (expiresAt) => {
    if (!expiresAt) return false;
    const expireDate = new Date(expiresAt);
    const now = new Date();
    const threeDaysFromNow = new Date(now);
    threeDaysFromNow.setDate(now.getDate() + 3);
    
    return expireDate <= threeDaysFromNow && expireDate > now;
    };
  
  // Navigasi pengumuman
  const nextAnnouncement = () => {
    if (currentAnnouncementIndex.value < activeAnnouncements.value.length - 1) {
      currentAnnouncementIndex.value++;
    } else {
      currentAnnouncementIndex.value = 0;
    }
  };
  
  const prevAnnouncement = () => {
    if (currentAnnouncementIndex.value > 0) {
      currentAnnouncementIndex.value--;
    } else {
      // Jika di awal, pergi ke akhir
      currentAnnouncementIndex.value = activeAnnouncements.value.length - 1;
    }
  };
  
  // Tutup modal pengumuman
  const closeAnnouncementModal = () => {
    // Tandai semua pengumuman sebagai sudah dilihat
    const seenAnnouncements = JSON.parse(localStorage.getItem('seen_announcements') || '[]');
    const newSeenAnnouncements = [...new Set([...seenAnnouncements, ...activeAnnouncements.value.map(a => a.id)])];
    localStorage.setItem('seen_announcements', JSON.stringify(newSeenAnnouncements));
    
    // Reset state
    hasSeenAnnouncements.value = true;
    showAnnouncementModal.value = false;
    activeAnnouncements.value = [];
    
    // Unblock scroll
    document.body.style.overflow = 'auto';
    
    // Refresh AOS untuk konten yang blur
    useAOSRefresh();
  };
  
  // Auto slide pengumuman
  let announcementInterval;
  const startAnnouncementAutoSlide = () => {
    if (announcementInterval) clearInterval(announcementInterval);
    
    if (activeAnnouncements.value.length > 1 && showAnnouncementModal.value) {
      announcementInterval = setInterval(() => {
        nextAnnouncement();
      }, 10000); // Ganti slide setiap 10 detik
    }
  };
  
  onMounted(async () => {
    // Cek apakah sudah melihat pengumuman hari ini
    const lastSeenDate = localStorage.getItem('last_seen_announcements_date');
    const today = new Date().toDateString();
    
    if (lastSeenDate !== today) {
      // Reset status jika hari baru
      localStorage.setItem('last_seen_announcements_date', today);
      localStorage.removeItem('seen_announcements');
      hasSeenAnnouncements.value = false;
    } else {
      hasSeenAnnouncements.value = true;
    }
    
    // Ambil data event
    if (!eventStore.events.length && !eventStore.loading) {
      eventStore.fetchEvents();
    }
    
    // Ambil data bidang dan pengumuman secara paralel
    await Promise.all([
      fetchBidangs(),
      fetchActiveAnnouncements()
    ]);
    
    // Mulai auto slide jika modal ditampilkan
    if (showAnnouncementModal.value) {
      startAnnouncementAutoSlide();
    }
  });
  
  // Watch untuk restart auto slide saat index berubah
  watch(currentAnnouncementIndex, () => {
    if (showAnnouncementModal.value) {
      startAnnouncementAutoSlide();
    }
  });
  
  onBeforeUnmount(() => {
    if (announcementInterval) {
      clearInterval(announcementInterval);
    }
    // Pastikan scroll di-unblock
    document.body.style.overflow = 'auto';
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
  </script>
  
  <style scoped>
  /* Animation untuk modal masuk */
  @keyframes scale-in {
    0% {
      opacity: 0;
      transform: scale(0.95) translateY(10px);
    }
    100% {
      opacity: 1;
      transform: scale(1) translateY(0);
    }
  }
  
  .animate-scale-in {
    animation: scale-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }
  
  /* Blur effect yang lebih halus */
  .blur-sm {
    filter: blur(3px);
    transition: filter 0.4s ease;
  }
  
  .pointer-events-none {
    pointer-events: none;
  }
  
  /* Scrollbar styling untuk modal */
  .modal-scrollbar::-webkit-scrollbar {
    width: 10px;
  }
  
  .modal-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 5px;
  }
  
  .modal-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #3b82f6, #1d4ed8);
    border-radius: 5px;
    border: 2px solid #f1f5f9;
  }
  
  .modal-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #2563eb, #1e40af);
  }
  
  /* High z-index untuk mengatasi navbar */
  .z-\[9999\] {
    z-index: 9999;
  }
  
  /* Styling untuk gambar kotak */
  img {
    aspect-ratio: 1 / 1;
    object-fit: cover;
    object-position: center;
  }
  
  /* Smooth transition untuk semua elemen */
  .transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
  }
  
  /* Styling untuk card info waktu */
  .bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
  }
  
  @keyframes gradient {
    0% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
    100% {
      background-position: 0% 50%;
    }
  }
  
  /* Hover effect untuk tombol navigasi */
  button:hover {
    transform: translateY(-1px);
  }
  
  button:active {
    transform: translateY(0);
  }
  </style>