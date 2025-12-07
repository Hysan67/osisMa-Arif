<template>
  <div class="min-h-screen flex bg-gray-100 relative">
    
    <!-- MAIN -->
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#1E40AF]">Kelola Artikel</h2>
        <button @click="openForm()" class="bg-[#1E40AF] hover:bg-[#1E3A8A] text-white px-4 py-2 rounded">
          + Artikel Baru
        </button>
      </div>

      <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full">
          <thead class="bg-blue-700 text-white">
            <tr>
              <th class="py-2 px-4 text-left">Judul</th>
              <th class="py-2 px-4 text-center w-40">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="artikel in artikels" :key="artikel.id" class="even:bg-white odd:bg-gray-50">
              <td class="py-2 px-4 border-b">{{ artikel.judul }}</td>
              <td class="py-2 px-4 border-b text-center space-x-2">
                <button @click="openForm(artikel)" class="text-yellow-500 hover:text-yellow-600">✏️</button>
                <button @click="deleteArtikel(artikel.id)" class="text-red-600 hover:text-red-700">🗑️</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- FORM MODAL -->
      <div v-if="showForm" class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center">
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
              <input type="file" @change="handleFileUpload" class="w-full border px-3 py-2 rounded" accept="image/*" />
            </div>

            <div class="flex justify-end space-x-3">
              <button type="button" @click="closeForm" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
              <button type="submit" class="px-4 py-2 bg-[#1E40AF] text-white rounded">
                {{ isEdit ? "Update" : "Simpan" }}
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- ALERT -->
      <transition name="fade-slide">
        <div v-if="alert.show" class="fixed bottom-6 right-6 px-4 py-3 rounded-lg shadow-lg text-white" :class="alert.color">
          {{ alert.message }}
        </div>
      </transition>
    </main>
  </div>
</template>
<script setup>
  import { ref, onMounted } from "vue";
  import axios from "axios";
  import { toRaw } from 'vue'
  
  const artikels = ref([]);
  const showForm = ref(false);
  const isEdit = ref(false);
  const form = ref({
    id: null,
    judul: "",
    deskripsi: "",
    jenis_artikel: "artikel",
    img: null,
  });
  
  const alert = ref({ show: false, message: "", color: "bg-green-500" });
  
  function showAlert(msg, type = "success") {
    alert.value = {
      show: true,
      message: msg,
      color: type === "success" ? "bg-green-500" : "bg-red-500",
    };
    setTimeout(() => (alert.value.show = false), 3000);
  }
  
  function handleFileUpload(e) {
    form.value.img = e.target.files[0];
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
      };
    } else {
      form.value = {
        id: null,
        judul: "",
        deskripsi: "",
        jenis_artikel: "artikel",
        img: null,
      };
    }
    showForm.value = true;
  }
  
  function closeForm() {
    showForm.value = false;
  }
  
  // Di Vue component
  async function saveArtikel() {
  try {
    const formData = new FormData();
    
    // Tambahkan logging
    console.log('Form data:', {
      judul: form.value.judul,
      deskripsi: form.value.deskripsi,
      jenis_artikel: form.value.jenis_artikel
    });

    formData.append('judul', form.value.judul);
    formData.append('deskripsi', form.value.deskripsi);
    formData.append('jenis_artikel', form.value.jenis_artikel);

    if (form.value.img) {
      formData.append('img', form.value.img);
    }

    let response;
    if (isEdit.value) {
      console.log('Updating artikel ID:', form.value.id);
      response = await axios.put(`/artikels/${form.value.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
      console.log('Update response:', response.data);
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
    if (confirm("Hapus artikel ini?")) {
      try {
        await axios.delete(`/artikels/${id}`, {
          withCredentials: true // <-- Hapus ini, karena kamu pakai Sanctum token
        });
        showAlert("Artikel berhasil dihapus", "error");
        fetchArtikels(); // Refresh data
      } catch (err) {
        console.error(err);
        showAlert("Gagal menghapus artikel: " + (err.response?.data?.message || "Error"), "error");
      }
    }
  }
  
  async function fetchArtikels() {
  try {
    const response = await axios.get('/artikels', {
    });

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
  
  // --- TAMBAHKAN INI ---
  onMounted(() => {
    fetchArtikels();
  });
  // -------------------
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
</style>