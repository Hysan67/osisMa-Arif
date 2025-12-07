<template>
  <div class="min-h-screen flex bg-gray-100 relative">
    
    <!-- MAIN -->
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

      <!-- TABEL UTAMA DENGAN PREVIEW GAMBAR -->
      <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full">
          <thead class="bg-blue-700 text-white">
            <tr>
              <th class="py-2 px-4 text-center w-12">No</th>
              <th class="py-2 px-4 text-left w-20">Gambar</th>
              <th class="py-2 px-4 text-left">Judul</th>
              <th class="py-2 px-4 text-left w-24">Jenis</th>
              <th class="py-2 px-4 text-left w-40">Tanggal Dibuat</th>
              <th class="py-2 px-4 text-center w-40">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(artikel, index) in artikels" :key="artikel.id" class="even:bg-white odd:bg-gray-50 hover:bg-gray-100">
              <td class="py-3 px-4 border-b text-center">{{ index + 1 }}</td>
              <td class="py-3 px-4 border-b">
                <div class="flex justify-center">
                  <div v-if="artikel.img" class="relative group">
                    <img 
                      :src="getImageUrl(artikel.img)" 
                      :alt="artikel.judul"
                      class="w-12 h-12 object-cover rounded border border-gray-300 cursor-pointer"
                      @click="previewImage(artikel.img, artikel.judul)"
                    >
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded transition-all duration-200"></div>
                  </div>
                  <div v-else class="w-12 h-12 flex items-center justify-center bg-gray-200 rounded border border-gray-300">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
              </td>
              <td class="py-3 px-4 border-b">
                <div class="font-medium">{{ artikel.judul }}</div>
                <div class="text-sm text-gray-500 mt-1 line-clamp-1">{{ artikel.deskripsi }}</div>
              </td>
              <td class="py-3 px-4 border-b">
                <span :class="artikel.jenis_artikel === 'artikel' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'" class="px-2 py-1 rounded-full text-xs font-medium">
                  {{ artikel.jenis_artikel === 'artikel' ? 'Artikel' : 'Event' }}
                </span>
              </td>
              <td class="py-3 px-4 border-b text-sm">{{ formatDate(artikel.created_at) }}</td>
              <td class="py-3 px-4 border-b text-center space-x-2">
                <button @click="openForm(artikel)" class="text-yellow-500 hover:text-yellow-600" title="Edit">
                  <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </button>
                <button @click="deleteArtikel(artikel.id)" class="text-red-600 hover:text-red-700" title="Hapus">
                  <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- MODAL PREVIEW GAMBAR BESAR -->
      <div v-if="showImagePreview" class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center z-[100] p-4">
        <div class="bg-white rounded-lg shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col">
          <div class="flex-shrink-0 flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold">{{ previewImageTitle }}</h3>
            <button @click="closeImagePreview" class="text-gray-500 hover:text-gray-700 p-1">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          <div class="flex-1 overflow-hidden p-4 flex items-center justify-center">
            <img 
              :src="previewImageUrl" 
              :alt="previewImageTitle"
              class="max-w-full max-h-full object-contain"
            >
          </div>
          <div class="flex-shrink-0 border-t p-4 text-center">
            <a :href="previewImageUrl" target="_blank" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
              </svg>
              Buka Gambar di Tab Baru
            </a>
          </div>
        </div>
      </div>

      <!-- MODAL FORM ARTIKEL -->
      <div v-if="showForm" class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50">
        <div class="bg-white rounded-md shadow-lg max-w-lg w-full p-6">
          <h3 class="text-xl font-semibold mb-4">{{ isEdit ? "Edit Artikel" : "Artikel Baru" }}</h3>

          <form @submit.prevent="saveArtikel">
            <div class="mb-4">
              <label class="block mb-1 font-medium">Judul</label>
              <input v-model="form.judul" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div class="mb-4">
              <label class="block mb-1 font-medium">Isi Singkat</label>
              <textarea v-model="form.deskripsi" rows="4" class="w-full border px-3 py-2 rounded" required></textarea>
            </div>

            <div class="mb-4">
              <label class="block mb-1 font-medium">Jenis Artikel</label>
              <select v-model="form.jenis_artikel" class="w-full border px-3 py-2 rounded" required>
                <option value="artikel">Artikel</option>
                <option value="event">Event</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block mb-1 font-medium">Gambar (Opsional)</label>
              <div v-if="form.img && form.img.name" class="mb-3">
                <p class="text-sm text-gray-600 mb-1">File dipilih: {{ form.img.name }}</p>
                <img v-if="form.imgPreview" :src="form.imgPreview" class="w-32 h-32 object-cover rounded border">
              </div>
              <input type="file" @change="handleFileUpload" class="w-full border px-3 py-2 rounded" accept="image/*" />
              <p class="text-sm text-gray-500 mt-1">Maksimal 2MB, format: jpeg, png, jpg, gif</p>
            </div>

            <div class="flex justify-end space-x-3">
              <button type="button" @click="closeForm" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
              <button type="submit" class="px-4 py-2 bg-[#1E40AF] text-white rounded hover:bg-[#1E3A8A]">
                {{ isEdit ? "Update" : "Simpan" }}
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- MODAL HISTORY ARTIKEL DENGAN PREVIEW GAMBAR -->
      <div v-if="showHistoryModal" class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50 p-4">
        <div class="bg-white rounded-md shadow-lg w-full max-w-6xl max-h-[80vh] flex flex-col">
          <!-- Header Modal -->
          <div class="flex-shrink-0 flex justify-between items-center p-6 border-b">
            <h3 class="text-xl font-semibold">History Artikel Terhapus</h3>
            <button @click="closeHistoryModal" class="text-gray-500 hover:text-gray-700">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- Content Area yang BISA DI-SCROLL -->
          <div class="flex-1 overflow-y-auto p-6">
            <div v-if="deletedArtikels.length === 0" class="text-center py-12 text-gray-500">
              <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
              </svg>
              <p class="text-lg">Tidak ada artikel yang dihapus</p>
              <p class="text-sm mt-2">Artikel yang dihapus akan muncul di sini</p>
            </div>

            <div v-else>
              <div class="overflow-x-auto">
                <table class="w-full">
                  <thead class="bg-gray-700 text-white">
                    <tr>
                      <th class="py-3 px-4 text-center w-12">No</th>
                      <th class="py-3 px-4 text-center w-20">Gambar</th>
                      <th class="py-3 px-4 text-left min-w-[200px]">Judul</th>
                      <th class="py-3 px-4 text-left w-24">Jenis</th>
                      <th class="py-3 px-4 text-left min-w-[180px]">Dihapus Pada</th>
                      <th class="py-3 px-4 text-center w-48">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(artikel, index) in deletedArtikels" :key="artikel.id" class="even:bg-gray-50 odd:bg-white border-b hover:bg-gray-100">
                      <td class="py-3 px-4 text-center">{{ index + 1 }}</td>
                      <td class="py-3 px-4 text-center">
                        <div class="flex justify-center">
                          <div v-if="artikel.img" class="relative group">
                            <img 
                              :src="getImageUrl(artikel.img)" 
                              :alt="artikel.judul"
                              class="w-12 h-12 object-cover rounded border border-gray-300 cursor-pointer"
                              @click="previewImage(artikel.img, artikel.judul)"
                            >
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded transition-all duration-200"></div>
                          </div>
                          <div v-else class="w-12 h-12 flex items-center justify-center bg-gray-200 rounded border border-gray-300">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                          </div>
                        </div>
                      </td>
                      <td class="py-3 px-4">
                        <div class="font-medium">{{ artikel.judul }}</div>
                        <div class="text-sm text-gray-500 mt-1 line-clamp-2">{{ artikel.deskripsi }}</div>
                      </td>
                      <td class="py-3 px-4">
                        <span :class="artikel.jenis_artikel === 'artikel' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'" class="px-3 py-1 rounded-full text-xs font-medium inline-block">
                          {{ artikel.jenis_artikel === 'artikel' ? 'Artikel' : 'Event' }}
                        </span>
                      </td>
                      <td class="py-3 px-4">{{ formatDate(artikel.deleted_at) }}</td>
                      <td class="py-3 px-4 text-center space-x-2">
                        <button @click="restoreArtikel(artikel.id)" class="text-green-600 hover:text-green-700 px-3 py-1.5 border border-green-600 rounded hover:bg-green-50 transition-colors" title="Kembalikan">
                          <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                          </svg>
                          Restore
                        </button>
                        <button @click="permanentDeleteArtikel(artikel.id)" class="text-red-600 hover:text-red-700 px-3 py-1.5 border border-red-600 rounded hover:bg-red-50 transition-colors" title="Hapus Permanen">
                          <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                          </svg>
                          Hapus
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <!-- Info jumlah data -->
              <div class="mt-4 px-2 py-2 text-sm text-gray-600 bg-gray-100 rounded">
                Total: {{ deletedArtikels.length }} artikel terhapus
              </div>
            </div>
          </div>
          
          <!-- Footer Modal -->
          <div class="flex-shrink-0 border-t p-4 bg-gray-50">
            <div class="flex justify-end">
              <button @click="closeHistoryModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Tutup
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- ALERT -->
      <transition name="fade-slide">
        <div v-if="alert.show" class="fixed bottom-6 right-6 px-4 py-3 rounded-lg shadow-lg text-white z-50" :class="alert.color">
          {{ alert.message }}
        </div>
      </transition>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const artikels = ref([]);
const deletedArtikels = ref([]);
const showForm = ref(false);
const showHistoryModal = ref(false);
const showImagePreview = ref(false);
const isEdit = ref(false);

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

function showAlert(msg, type = "success") {
  alert.value = {
    show: true,
    message: msg,
    color: type === "success" ? "bg-green-500" : "bg-red-500",
  };
  setTimeout(() => (alert.value.show = false), 3000);
}

function handleFileUpload(e) {
  const file = e.target.files[0];
  if (file) {
    form.value.img = file;
    
    // Buat preview untuk gambar yang baru diupload
    const reader = new FileReader();
    reader.onload = (e) => {
      form.value.imgPreview = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}

function getImageUrl(imgPath) {
  if (!imgPath) return '';
  
  // Jika sudah full URL (misal dari preview), return langsung
  if (imgPath.startsWith('http') || imgPath.startsWith('data:')) {
    return imgPath;
  }
  
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

function openForm(data) {
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

async function saveArtikel() {
  try {
    const formData = new FormData();
    formData.append('judul', form.value.judul);
    formData.append('deskripsi', form.value.deskripsi);
    formData.append('jenis_artikel', form.value.jenis_artikel);

    if (form.value.img) {
      formData.append('img', form.value.img);
    }

    let response;
    if (isEdit.value) {
      formData.append('_method', 'PUT');
      response = await axios.post(`/artikels/${form.value.id}`, formData, {
        headers: { 
          'Content-Type': 'multipart/form-data'
        }
      });
      showAlert("Artikel berhasil diperbarui");
    } else {
      response = await axios.post('/artikels', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
      showAlert("Artikel baru berhasil ditambahkan");
    }
    
    closeForm();
    await fetchArtikels();
  } catch (err) {
    console.error("Error detail:", err);
    console.error("Error response:", err.response?.data);
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

async function fetchDeletedArtikels() {
  try {
    console.log('Fetching deleted artikels from:', '/artikels-trash');
    
    const response = await axios.get('/artikels-trash');
    
    console.log('Response:', response);
    console.log('Response data:', response.data);
    
    if (response.data.success && response.data.data) {
      deletedArtikels.value = response.data.data;
    } else {
      deletedArtikels.value = response.data;
    }
    
    console.log('Deleted artikels loaded:', deletedArtikels.value);
  } catch (err) {
    console.error('Error fetching deleted artikels:', err);
    console.error('Error response:', err.response);
    console.error('Error status:', err.response?.status);
    console.error('Error data:', err.response?.data);
    
    showAlert("Gagal memuat artikel terhapus: " + (err.response?.data?.message || "Error"), "error");
  }
}

async function restoreArtikel(id) {
  if (confirm("Apakah Anda yakin ingin mengembalikan artikel ini?")) {
    try {
      console.log('Restoring artikel ID:', id);
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
      console.log('Force deleting artikel ID:', id);
      await axios.delete(`/artikels-force/${id}`);
      showAlert("Artikel berhasil dihapus permanen", "success");
      await fetchDeletedArtikels();
    } catch (err) {
      console.error(err);
      showAlert("Gagal menghapus permanen artikel: " + (err.response?.data?.message || "Error"), "error");
    }
  }
}

async function fetchArtikels() {
  try {
    const response = await axios.get('/artikels');
    
    if (response.data.data) {
      artikels.value = response.data.data;
    } else {
      artikels.value = response.data;
    }
  } catch (err) {
    console.error(err);
    showAlert("Gagal memuat artikel: " + (err.response?.data?.message || "Error"), "error");
  }
}

onMounted(() => {
  fetchArtikels();
});
</script>

<style>
.font-cursive {
  font-family: "Indie Flower", cursive;
}
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.4s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

/* Untuk line clamp */
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Untuk scroll yang smooth */
.overflow-y-auto {
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

.overflow-y-auto::-webkit-scrollbar {
  width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f7fafc;
  border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background-color: #cbd5e0;
  border-radius: 4px;
  border: 2px solid #f7fafc;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background-color: #a0aec0;
}

/* Efek hover untuk gambar */
.group:hover .group-hover\:bg-opacity-20 {
  background-color: rgba(0, 0, 0, 0.2);
}

/* Untuk modal yang responsive */
@media (max-height: 640px) {
  .max-h-\[80vh\] {
    max-height: 90vh !important;
  }
}

/* Transisi untuk gambar */
img {
  transition: transform 0.2s ease;
}

img:hover {
  transform: scale(1.05);
}
</style>