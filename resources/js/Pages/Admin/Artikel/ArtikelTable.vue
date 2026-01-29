<template>
  <div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <thead class="bg-blue-700 text-white">
          <tr>
            <th class="py-2 px-4 text-center w-12">No</th>
            <th class="py-2 px-4 text-left w-20">Gambar</th>
            <th class="py-2 px-4 text-left">Judul</th>
            <th class="py-2 px-4 text-left w-24">Jenis</th>
            <th class="py-2 px-4 text-left w-40">Tanggal Dibuat</th>
            <th class="py-2 px-4 text-left w-48">Kedaluwarsa</th>
            <th class="py-2 px-4 text-center w-40">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(artikel, index) in artikels" :key="artikel.id" class="even:bg-white odd:bg-gray-50 hover:bg-gray-100">
            <td class="py-3 px-4 border-b text-center">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
            <td class="py-3 px-4 border-b">
              <ImageThumbnail 
                :img-path="artikel.img"
                :alt="artikel.judul"
                @click="$emit('preview-image', artikel.img, artikel.judul)"
              />
            </td>
            <td class="py-3 px-4 border-b">
              <div class="font-medium">{{ artikel.judul }}</div>
              <div class="text-sm text-gray-500 mt-1 line-clamp-1">{{ artikel.deskripsi }}</div>
            </td>
            <td class="py-3 px-4 border-b">
              <ArticleTypeBadge :type="artikel.jenis_artikel" />
            </td>
            <td class="py-3 px-4 border-b text-sm">{{ formatDate(artikel.created_at) }}</td>
            
            <td class="py-3 px-4 border-b text-sm">
              <div v-if="artikel.jenis_artikel === 'pengumuman'">
                <span v-if="artikel.expires_at" 
                      :class="isExpired(artikel.expires_at) ? 'text-red-600 font-medium' : 'text-gray-700'">
                  {{ formatDate(artikel.expires_at) }}
                  <span v-if="isExpired(artikel.expires_at)" class="ml-1 text-xs text-red-500">(Expired)</span>
                </span>
                <span v-else class="text-gray-400 italic">Tanpa batas</span>
              </div>
              <span v-else class="text-gray-400">-</span>
            </td>
            
            <!-- HAPUS KOLOM STATUS -->
            
            <td class="py-3 px-4 border-b text-center space-x-2">
              <button @click="$emit('open-form', artikel)" class="text-yellow-500 hover:text-yellow-600" title="Edit">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
              </button>
              <button @click="$emit('delete-artikel', artikel.id)" class="text-red-600 hover:text-red-700" title="Hapus">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      
      <!-- Empty State -->
      <div v-if="artikels.length === 0" class="text-center py-8 text-gray-500">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-lg">Tidak ada artikel yang ditemukan</p>
        <p v-if="searchQuery" class="text-sm mt-2">
          Coba gunakan kata kunci lain atau 
          <button @click="$emit('clear-search')" class="text-blue-600 hover:text-blue-800">hapus pencarian</button>
        </p>
      </div>
    </div>
    
    <!-- Pagination -->
    <Pagination 
      v-if="filteredArtikels.length > itemsPerPage"
      :current-page="currentPage"
      :total-items="filteredArtikels.length"
      :items-per-page="itemsPerPage"
      @page-change="$emit('page-change', $event)"
    />
  </div>
</template>

<script setup>
import ImageThumbnail from './partials/ImageThumbnail.vue';
import ArticleTypeBadge from './partials/ArticleTypeBadge.vue';
import Pagination from './partials/Pagination.vue';

defineProps({
  artikels: Array,
  currentPage: Number,
  itemsPerPage: Number,
  filteredArtikels: Array,
  searchQuery: String
});

defineEmits(['open-form', 'delete-artikel', 'preview-image', 'page-change', 'clear-search']);

function formatDate(dateString) {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
}

function isExpired(expiresAt) {
  if (!expiresAt) return false;
  return new Date(expiresAt) < new Date();
}
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>