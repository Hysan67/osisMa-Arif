<template>
  <div class="min-h-screen flex bg-gray-100 relative">
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#1E40AF]">Kelola Artikel</h2>
        <div class="flex space-x-3">
          <button @click="openHistoryModal" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            History Artikel
          </button>
          <button @click="openForm()" class="bg-[#1E40AF] hover:bg-[#1E3A8A] text-white px-4 py-2 rounded flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Artikel Baru
          </button>
        </div>
      </div>

      <!-- Search Bar -->
      <SearchBar 
        v-model="searchQuery"
        @clear="clearSearch"
        :result-count="filteredArtikels.length"
        :total-count="artikels.length"
      />

      <!-- Artikel Table -->
      <ArtikelTable 
        :artikels="displayedArtikels"
        :current-page="currentPage"
        :items-per-page="itemsPerPage"
        :filtered-artikels="filteredArtikels"
        :search-query="searchQuery"
        @open-form="openForm"
        @delete-artikel="deleteArtikel"
        @preview-image="previewImage"
        @page-change="goToPage"
      />

      <!-- Modals -->
      <ArtikelForm 
        v-if="showForm"
        :is-edit="isEdit"
        :form-data="form"
        @save="saveArtikel"
        @close="closeForm"
        @file-upload="handleFileUpload"
      />

      <ArtikelHistory 
        v-if="showHistoryModal"
        :deleted-artikels="deletedArtikels"
        @close="closeHistoryModal"
        @restore="restoreArtikel"
        @permanent-delete="permanentDeleteArtikel"
        @preview-image="previewImage"
      />

      <ImagePreview 
        v-if="showImagePreview"
        :image-url="previewImageUrl"
        :image-title="previewImageTitle"
        @close="closeImagePreview"
      />

      <!-- Alert -->
      <transition name="fade-slide">
        <div v-if="alert.show" class="fixed bottom-6 right-6 px-4 py-3 rounded-lg shadow-lg text-white z-50" :class="alert.color">
          {{ alert.message }}
        </div>
      </transition>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import axios from "axios";

import ArtikelTable from './Artikel/ArtikelTable.vue';
import ArtikelForm from './Artikel/ArtikelForm.vue';
import ArtikelHistory from './Artikel/ArtikelHistory.vue';
import ImagePreview from './Artikel/ImagePreview.vue';
import SearchBar from './Artikel/SearchBar.vue';

const artikels = ref([]);
const deletedArtikels = ref([]);
const showForm = ref(false);
const showHistoryModal = ref(false);
const showImagePreview = ref(false);
const isEdit = ref(false);
const searchQuery = ref("");
const currentPage = ref(1);
const itemsPerPage = 10;

const form = ref({
  id: null,
  judul: "",
  deskripsi: "",
  jenis_artikel: "artikel",
  img: null,
  imgPreview: null,
});

const alert = ref({ show: false, message: "", color: "bg-green-500" });
const previewImageUrl = ref("");
const previewImageTitle = ref("");

// Computed Properties
const filteredArtikels = computed(() => {
  if (!searchQuery.value) return artikels.value;
  
  const query = searchQuery.value.toLowerCase();
  return artikels.value.filter(artikel => 
    artikel.judul.toLowerCase().includes(query) ||
    artikel.deskripsi.toLowerCase().includes(query) ||
    artikel.jenis_artikel.toLowerCase().includes(query)
  );
});

const displayedArtikels = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredArtikels.value.slice(start, end);
});

// Methods
function showAlert(msg, type = "success") {
  alert.value = { show: true, message: msg, color: type === "success" ? "bg-green-500" : "bg-red-500" };
  setTimeout(() => (alert.value.show = false), 3000);
}

function handleFileUpload(e) {
  const file = e.target.files[0];
  if (file) {
    form.value.img = file;
    const reader = new FileReader();
    reader.onload = (e) => form.value.imgPreview = e.target.result;
    reader.readAsDataURL(file);
  }
}

function getImageUrl(imgPath) {
  if (!imgPath) return '';
  if (imgPath.startsWith('http') || imgPath.startsWith('data:')) return imgPath;
  if (imgPath.startsWith('public/')) imgPath = imgPath.replace('public/', '');
  if (imgPath.startsWith('/')) imgPath = imgPath.substring(1);
  return `/storage/${imgPath}`;
}

function previewImage(imgPath, title) {
  previewImageUrl.value = getImageUrl(imgPath);
  previewImageTitle.value = title;
  showImagePreview.value = true;
}

function closeImagePreview() {
  showImagePreview.value = false;
  previewImageUrl.value = "";
  previewImageTitle.value = "";
}

function openForm(data = null) {
  isEdit.value = !!data;
  if (data) {
    form.value = {
      id: data.id,
      judul: data.judul,
      deskripsi: data.deskripsi,
      jenis_artikel: data.jenis_artikel || "artikel",
      img: null,
      imgPreview: data.img ? getImageUrl(data.img) : null,
    };
  } else {
    form.value = {
      id: null,
      judul: "",
      deskripsi: "",
      jenis_artikel: "artikel",
      img: null,
      imgPreview: null,
    };
  }
  showForm.value = true;
}

function closeForm() {
  showForm.value = false;
  form.value.imgPreview = null;
}

function openHistoryModal() {
  fetchDeletedArtikels();
  showHistoryModal.value = true;
}

function closeHistoryModal() {
  showHistoryModal.value = false;
}

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

// Search & Pagination
function onSearch() {
  currentPage.value = 1;
}

function clearSearch() {
  searchQuery.value = "";
  currentPage.value = 1;
}

function goToPage(page) {
  if (page >= 1 && page <= Math.ceil(filteredArtikels.value.length / itemsPerPage)) {
    currentPage.value = page;
  }
}

// API Functions
async function fetchArtikels() {
  try {
    const response = await axios.get('/artikels');
    artikels.value = response.data.data || response.data;
    currentPage.value = 1;
  } catch (err) {
    console.error(err);
    showAlert("Gagal memuat artikel: " + (err.response?.data?.message || "Error"), "error");
  }
}

async function fetchDeletedArtikels() {
  try {
    const response = await axios.get('/artikels-trash');
    deletedArtikels.value = response.data.data || response.data;
  } catch (err) {
    console.error('Error fetching deleted artikels:', err);
    showAlert("Gagal memuat artikel terhapus: " + (err.response?.data?.message || "Error"), "error");
  }
}

async function saveArtikel() {
  try {
    const formData = new FormData();
    formData.append('judul', form.value.judul);
    formData.append('deskripsi', form.value.deskripsi);
    formData.append('jenis_artikel', form.value.jenis_artikel);

    if (form.value.img) formData.append('img', form.value.img);

    if (isEdit.value) {
      formData.append('_method', 'PUT');
      await axios.post(`/artikels/${form.value.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
      showAlert("Artikel berhasil diperbarui");
    } else {
      await axios.post('/artikels', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
      showAlert("Artikel baru berhasil ditambahkan");
    }
    
    closeForm();
    await fetchArtikels();
  } catch (err) {
    console.error("Error detail:", err);
    let errorMessage = "Gagal menyimpan artikel";
    if (err.response?.data?.message) {
      errorMessage = err.response.data.message;
    } else if (err.response?.data?.errors) {
      errorMessage = Object.values(err.response.data.errors).flat().join(', ');
    }
    showAlert(errorMessage, "error");
  }
}

async function deleteArtikel(id) {
  if (confirm("Apakah Anda yakin ingin menghapus artikel ini?")) {
    try {
      await axios.delete(`/artikels/${id}`);
      showAlert("Artikel berhasil dihapus", "success");
      await fetchArtikels();
    } catch (err) {
      console.error(err);
      showAlert("Gagal menghapus artikel: " + (err.response?.data?.message || "Error"), "error");
    }
  }
}

async function restoreArtikel(id) {
  if (confirm("Apakah Anda yakin ingin mengembalikan artikel ini?")) {
    try {
      await axios.put(`/artikels-restore/${id}`);
      showAlert("Artikel berhasil dikembalikan", "success");
      await fetchDeletedArtikels();
      await fetchArtikels();
    } catch (err) {
      console.error(err);
      showAlert("Gagal mengembalikan artikel: " + (err.response?.data?.message || "Error"), "error");
    }
  }
}

async function permanentDeleteArtikel(id) {
  if (confirm("Apakah Anda yakin ingin menghapus permanen artikel ini? Tindakan ini tidak dapat dibatalkan!")) {
    try {
      await axios.delete(`/artikels-force/${id}`);
      showAlert("Artikel berhasil dihapus permanen", "success");
      await fetchDeletedArtikels();
    } catch (err) {
      console.error(err);
      showAlert("Gagal menghapus permanen artikel: " + (err.response?.data?.message || "Error"), "error");
    }
  }
}

// Lifecycle
onMounted(() => {
  fetchArtikels();
});

watch(filteredArtikels, () => {
  const totalPages = Math.ceil(filteredArtikels.value.length / itemsPerPage);
  if (currentPage.value > totalPages) {
    currentPage.value = Math.max(1, totalPages);
  }
});
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.4s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
</style>