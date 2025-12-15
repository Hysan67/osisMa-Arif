<template>
  <div class="container mx-auto px-4 py-8">
    <!-- Status Message -->
    <div v-if="statusMessage" class="mb-6 p-4 rounded-lg shadow-md" :class="statusType === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'">
      {{ statusMessage }}
    </div>

    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Bidang OSIS</h1>
      <p class="text-gray-600 mb-4">Kelola data bidang-bidang OSIS sekolah</p>
      
      <div class="flex space-x-3">
        <!-- Tombol Lihat Bidang Dihapus -->
        <router-link 
          to="/admin/trashed-bidang"
          class="flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
          Lihat Bidang Dihapus
        </router-link>
        
        <!-- Tombol Tambah Bidang Baru -->
        <button
          @click="openForm()"
          class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Tambah Bidang Baru
        </button>
      </div>
    </div>
    <!-- Loading State -->
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
      <p class="mt-4 text-gray-600">Memuat data bidang...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-6 text-center mb-6">
      <div class="text-red-600 mb-2">
        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <h3 class="text-lg font-medium text-red-800 mb-2">Gagal memuat data</h3>
      <p class="text-red-700 mb-4">{{ error }}</p>
      <button
        @click="fetchBidangs"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg"
      >
        Coba Lagi
      </button>
    </div>

    <!-- Empty State -->
    <div v-else-if="bidangs.length === 0" class="bg-white rounded-lg shadow p-8 text-center">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
      </svg>
      <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada bidang</h3>
      <p class="text-gray-600 mb-6">Mulai dengan menambahkan bidang pertama Anda</p>
      <button
        @click="openForm()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
      >
        Tambah Bidang Pertama
      </button>
    </div>

    <!-- Bidang Grid -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="bidang in bidangs"
        :key="bidang.id"
        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition"
      >
        <!-- Gambar Bidang -->
        <div class="h-48 overflow-hidden">
          <img
            :src="getImageUrl(bidang.img)"
            :alt="bidang.nama"
            class="w-full h-full object-cover"
            @error="handleImageError"
          />
        </div>
        
        <!-- Content -->
        <div class="p-6">
          <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ bidang.nama }}</h3>
          
          <div class="mb-4">
            <h4 class="text-sm font-medium text-gray-700 mb-1">Tugas Umum:</h4>
            <p class="text-gray-600 text-sm line-clamp-2">{{ bidang.tugas_umum }}</p>
          </div>
          
          <div class="mb-6">
            <h4 class="text-sm font-medium text-gray-700 mb-1">Deskripsi:</h4>
            <p class="text-gray-600 text-sm line-clamp-3">{{ bidang.deskripsi }}</p>
          </div>
          
          <!-- Actions -->
          <div class="flex justify-between items-center pt-4 border-t border-gray-100">
            <span class="text-sm text-gray-500">
              {{ formatDate(bidang.created_at) }}
            </span>
            <div class="flex space-x-2">
              <button
                @click="viewBidang(bidang.id)"
                class="text-blue-600 hover:text-blue-800 p-1"
                title="Detail"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </button>
              <button
                @click="editBidang(bidang)"
                class="text-green-600 hover:text-green-800 p-1"
                title="Edit"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
              </button>
              <button
                @click="confirmDelete(bidang)"
                class="text-red-600 hover:text-red-800 p-1"
                title="Hapus"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
          <h2 class="text-xl font-semibold text-gray-800">
            {{ isEdit ? 'Edit Bidang' : 'Tambah Bidang Baru' }}
          </h2>
          <button
            @click="closeModal"
            class="text-gray-400 hover:text-gray-600"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
          <form @submit.prevent="saveBidang">
            <!-- Nama Bidang -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-2" for="nama">
                Nama Bidang *
              </label>
              <input
                v-model="form.nama"
                type="text"
                id="nama"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Contoh: Bidang Keamanan & Ketertiban"
              />
              <p v-if="errors.nama" class="mt-1 text-sm text-red-600">{{ errors.nama[0] }}</p>
            </div>

            <!-- Gambar -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-2">
                Gambar Bidang
              </label>
              
              <!-- Image Preview -->
              <div v-if="form.imgPreview" class="mb-3">
                <img
                  :src="form.imgPreview"
                  :alt="form.nama"
                  class="w-32 h-32 object-cover rounded-lg border border-gray-300"
                />
              </div>

              <!-- File Input -->
              <div class="flex items-center">
                <label class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                  <input
                    type="file"
                    @change="handleFileUpload"
                    accept="image/*"
                    class="hidden"
                  />
                  {{ form.imgPreview ? 'Ganti Gambar' : 'Unggah Gambar' }}
                </label>
                <button
                  v-if="form.imgPreview"
                  @click="removeImage"
                  type="button"
                  class="ml-3 text-red-600 hover:text-red-800 text-sm"
                >
                  Hapus Gambar
                </button>
              </div>
              <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF</p>
              <p v-if="errors.img" class="mt-1 text-sm text-red-600">{{ errors.img[0] }}</p>
            </div>

            <!-- Tugas Umum -->
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-2" for="tugas_umum">
                Tugas Umum *
              </label>
              <textarea
                v-model="form.tugas_umum"
                id="tugas_umum"
                required
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Deskripsi singkat tugas utama bidang"
              ></textarea>
              <p v-if="errors.tugas_umum" class="mt-1 text-sm text-red-600">{{ errors.tugas_umum[0] }}</p>
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
              <label class="block text-gray-700 text-sm font-medium mb-2" for="deskripsi">
                Deskripsi Lengkap *
              </label>
              <textarea
                v-model="form.deskripsi"
                id="deskripsi"
                required
                rows="5"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Deskripsi detail tentang bidang, aktivitas, dan peran"
              ></textarea>
              <p v-if="errors.deskripsi" class="mt-1 text-sm text-red-600">{{ errors.deskripsi[0] }}</p>
            </div>

            <!-- Error Message -->
            <div v-if="submitError" class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
              <p class="text-sm text-red-600">{{ submitError }}</p>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
              <button
                type="button"
                @click="closeModal"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                :disabled="submitting"
              >
                Batal
              </button>
              <button
                type="submit"
                :disabled="submitting"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="submitting">
                  <svg class="animate-spin inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                  </svg>
                  Menyimpan...
                </span>
                <span v-else>{{ isEdit ? 'Update' : 'Simpan' }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div v-if="showDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
          <h2 class="text-xl font-semibold text-gray-800">{{ detailBidang?.nama }}</h2>
          <button
            @click="showDetailModal = false"
            class="text-gray-400 hover:text-gray-600"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <div class="p-6">
          <div class="mb-6">
            <img
              :src="getImageUrl(detailBidang?.img)"
              :alt="detailBidang?.nama"
              class="w-full h-64 object-cover rounded-lg"
              @error="handleImageError"
            />
          </div>

          <!-- Info -->
          <div class="space-y-4">
            <div>
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Tugas Umum</h3>
              <p class="text-gray-700">{{ detailBidang?.tugas_umum }}</p>
            </div>

            <div>
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Lengkap</h3>
              <p class="text-gray-700 whitespace-pre-line">{{ detailBidang?.deskripsi }}</p>
            </div>

            <div class="text-sm text-gray-500">
              <p>Dibuat: {{ formatDate(detailBidang?.created_at) }}</p>
              <p>Diupdate: {{ formatDate(detailBidang?.updated_at) }}</p>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
            <button
              @click="showDetailModal = false"
              class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
            >
              Tutup
            </button>
            <button
              @click="editBidang(detailBidang)"
              class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
              Edit Bidang
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const bidangs = ref([]);
const loading = ref(false);
const error = ref("");
const showModal = ref(false);
const showDetailModal = ref(false);
const isEdit = ref(false);
const submitting = ref(false);
const submitError = ref("");
const detailBidang = ref(null);
const bidangToDelete = ref(null);

const form = ref({
  id: null,
  nama: "",
  deskripsi: "",
  tugas_umum: "",
  img: null,
  imgPreview: null,
});

const errors = ref({});

// Status Message State
const statusMessage = ref("");
const statusType = ref(""); // 'success' atau 'error'

// Methods
function showStatus(msg, type = "success") {
  statusMessage.value = msg;
  statusType.value = type;

  // Hapus pesan setelah 3 detik
  setTimeout(() => {
    if (statusMessage.value === msg) { // Pastikan hanya menghapus pesan ini jika belum diganti
      statusMessage.value = "";
      statusType.value = "";
    }
  }, 3000);
}

function getImageUrl(imgPath) {
  try {
    if (!imgPath || imgPath.trim() === '') {
      return 'https://via.placeholder.com/400x300?text=No+Image';
    }
    
    if (imgPath.startsWith('http://') || imgPath.startsWith('https://')) {
      return imgPath;
    }
    
    let normalizedPath = imgPath;
    
    if (normalizedPath.startsWith('public/')) {
      normalizedPath = normalizedPath.substring(7);
    }
    
    if (normalizedPath.startsWith('/')) {
      normalizedPath = normalizedPath.substring(1);
    }
    
    if (normalizedPath.includes('bidangs/')) {
      if (!normalizedPath.startsWith('storage/')) {
        return `/storage/${normalizedPath}`;
      }
      return `/${normalizedPath}`;
    }
    
    return `/storage/bidangs/${normalizedPath}`;
  } catch (error) {
    console.error('Error generating image URL:', error);
    return 'https://via.placeholder.com/400x300?text=Error+Loading';
  }
}

function handleFileUpload(e) {
  const file = e.target.files[0];
  if (file) {
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
    if (!validTypes.includes(file.type)) {
      showStatus('Format file harus JPG, PNG, GIF, atau SVG', 'error');
      return;
    }
    
    form.value.img = file;
    const reader = new FileReader();
    reader.onload = (e) => form.value.imgPreview = e.target.result;
    reader.readAsDataURL(file);
    errors.value.img = '';
  }
}

async function removeImage() {
  try {
    if (isEdit.value && form.value.id) {
      const confirmDelete = confirm('Apakah Anda yakin ingin menghapus gambar ini?');
      if (!confirmDelete) return;

      const token = localStorage.getItem('token');
      
      // Kirim request untuk hapus gambar saja
      const response = await axios.put(`/bidang/${form.value.id}`, {
        nama: form.value.nama,
        deskripsi: form.value.deskripsi,
        tugas_umum: form.value.tugas_umum,
        remove_img: true // Flag untuk hapus gambar
      }, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        }
      });

      // Reset gambar di form
      form.value.img = null;
      form.value.imgPreview = null;
      
      showStatus("Gambar berhasil dihapus", "success");
      
      // Update data di list jika perlu
      await fetchBidangs();
    } else {
      // Jika bukan edit mode (tambah baru atau edit tanpa ID)
      form.value.img = null;
      form.value.imgPreview = null;
    }
  } catch (err) {
    console.error('Error deleting image:', err);
    const errorMessage = err.response?.data?.message || 'Gagal menghapus gambar';
    showStatus(errorMessage, "error");
  }
}

function formatDate(dateString) {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
}

// Form Methods
function openForm(data = null) {
  isEdit.value = !!data;
  if (data) {
    form.value = {
      id: data.id,
      nama: data.nama,
      deskripsi: data.deskripsi,
      tugas_umum: data.tugas_umum,
      img: null,
      imgPreview: data.img ? getImageUrl(data.img) : null,
    };
  } else {
    form.value = {
      id: null,
      nama: "",
      deskripsi: "",
      tugas_umum: "",
      img: null,
      imgPreview: null,
    };
  }
  errors.value = {};
  submitError.value = "";
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  form.value.imgPreview = null;
}

function editBidang(bidang) {
  openForm(bidang);
  showDetailModal.value = false;
}

async function viewBidang(id) {
  try {
    const token = localStorage.getItem('token');
    const response = await axios.get(`/bidang/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    
    detailBidang.value = response.data.data || response.data;
    showDetailModal.value = true;
  } catch (err) {
    console.error('Error viewing bidang:', err);
    showStatus("Gagal memuat detail bidang: " + (err.response?.data?.message || "Error"), "error");
  }
}

async function fetchBidangs() {
  loading.value = true;
  error.value = "";
  
  try {
    const token = localStorage.getItem('token');
    const response = await axios.get('/bidang', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    
    bidangs.value = response.data.data || response.data;
  } catch (err) {
    console.error('Error fetching bidangs:', err);
    error.value = 'Gagal memuat data bidang. Silakan coba lagi.';
    showStatus("Gagal memuat bidang: " + (err.response?.data?.message || "Error"), "error");
  } finally {
    loading.value = false;
  }
}

async function saveBidang() {
  submitting.value = true;
  submitError.value = "";
  errors.value = {};
  
  try {
    const token = localStorage.getItem('token');
    const formData = new FormData();
    
    formData.append('nama', form.value.nama);
    formData.append('deskripsi', form.value.deskripsi);
    formData.append('tugas_umum', form.value.tugas_umum);
    
    if (form.value.img) {
      formData.append('img', form.value.img);
    }
    
    if (isEdit.value) {
      formData.append('_method', 'PUT');
      await axios.post(`/bidang/${form.value.id}`, formData, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'multipart/form-data'
        }
      });
      showStatus("Bidang berhasil diperbarui");
    } else {
      await axios.post('/bidang', formData, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'multipart/form-data'
        }
      });
      showStatus("Bidang baru berhasil ditambahkan");
    }
    
    closeModal();
    await fetchBidangs();
  } catch (err) {
    console.error("Error detail:", err);
    let errorMessage = "Gagal menyimpan bidang";
    if (err.response?.data?.message) {
      errorMessage = err.response.data.message;
    } else if (err.response?.data?.errors) {
      errors.value = err.response.data.errors;
      errorMessage = Object.values(err.response.data.errors).flat().join(', ');
    }
    submitError.value = errorMessage;
    showStatus(errorMessage, "error");
  } finally {
    submitting.value = false;
  }
}

async function confirmDelete(bidang) {
  if (confirm(`Apakah Anda yakin ingin menghapus bidang "${bidang.nama}"?`)) {
    await deleteBidang(bidang.id);
  }
}

async function deleteBidang(id) {
  try {
    const token = localStorage.getItem('token');
    await axios.delete(`/bidang/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    showStatus("Bidang berhasil dihapus", "success");
    await fetchBidangs();
  } catch (err) {
    console.error(err);
    showStatus("Gagal menghapus bidang: " + (err.response?.data?.message || "Error"), "error");
  }
}

// Lifecycle
onMounted(() => {
  fetchBidangs();
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* Hilangkan style untuk alert */
/* .fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.4s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(20px);
} */
</style>