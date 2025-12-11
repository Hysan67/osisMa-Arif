<!-- src/components/BidangCard.vue -->
<template>
  <!-- Card Induk -->
  <div 
    @click="openDetailModal" 
    class="group block rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 cursor-pointer"
    :data-aos="aos" 
    :data-aos-delay="delay"
  >
    <div class="relative">
      <img 
        :src="getImageUrl(bidang.img)" 
        :alt="bidang.name" 
        class="w-full h-56 object-cover transition-transform duration-700 group-hover:scale-110" 
        :data-aos="aos" 
        :data-aos-delay="delay" 
        @error="handleImageError"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent transition-all duration-500 group-hover:from-black/80"></div>
      <div class="absolute bottom-0 left-0 right-0 p-5 text-white z-10 text-left">
        <h3 class="font-bold text-lg">{{ bidang.nama }}</h3>
        <p class="text-sm opacity-90 mt-1 line-clamp-2">{{ bidang.deskripsi }}</p>
      </div>
    </div>
  </div>

  <!-- Modal Detail -->
  <div 
    v-if="showModal" 
    class="fixed inset-0 flex items-center justify-center p-4 z-50"
    @click="closeModal"
  >
    <div 
      class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto"
      @click.stop
    >
      <!-- Header Modal -->
      <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-blue-600">{{ bidang.nama }}</h2>
        <button
          @click="closeModal"
          class="text-gray-500 hover:text-gray-700"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Body Modal -->
      <div class="p-6">
        <!-- Gambar Besar -->
        <div class="mb-6">
          <img 
            :src="getImageUrl(bidang.img)" 
            :alt="bidang.nama" 
            class="w-full h-64 object-cover rounded-lg"
            @error="handleImageError"
          />
        </div>

        <!-- Deskripsi Lengkap -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi:</h3>
          <p class="text-gray-700 leading-relaxed">{{ bidang.deskripsi || 'Tidak ada deskripsi.' }}</p>
        </div>

        <!-- Tugas Umum -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-2">Tugas Umum:</h3>
          <p class="text-gray-700">{{ bidang.tugas_umum || 'Tidak ada tugas umum yang dijelaskan.' }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  bidang: Object,
  aos: { type: String, default: 'fade-up' },
  delay: { type: Number, default: 500 }
})

const showModal = ref(false);

const openDetailModal = () => {
  document.body.style.overflow = 'hidden';
  showModal.value = true;
};

const closeModal = () => {
  document.body.style.overflow = '';
  showModal.value = false;
};

function getImageUrl(imgName) {
  return `/storage/bidangs/${imgName}`;
}

</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>