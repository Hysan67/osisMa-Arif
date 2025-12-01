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
            <td class="py-2 px-4 border-b">{{ artikel.title }}</td>
            <td class="py-2 px-4 border-b text-center space-x-2">
              <button @click="editMember(index)" class="text-yellow-500 hover:text-yellow-600">✏️</button>
              <button @click="hapusMember(index)" class="text-red-600 hover:text-red-700">🗑️</button>
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
              <input v-model="form.title" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div class="mb-4">
              <label class="block mb-1 font-medium">Isi Singkat</label>
              <textarea v-model="form.content" rows="4" class="w-full border px-3 py-2 rounded" required></textarea>
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
import { ref } from "vue";

const artikels = ref([
  { id: 1, title: "Artikel 1", content: "Isi artikel 1" },
  { id: 2, title: "Artikel 2", content: "Isi artikel 2" },
]);

const showForm = ref(false);
const isEdit = ref(false);
const form = ref({ id: null, title: "", content: "" });

const alert = ref({ show: false, message: "", color: "bg-green-500" });

function showAlert(msg, type = "success") {
  alert.value = {
    show: true,
    message: msg,
    color: type === "success" ? "bg-green-500" : "bg-red-500",
  };
  setTimeout(() => (alert.value.show = false), 3000);
}

function openForm(data = null) {
  isEdit.value = !!data;
  form.value = data ? { ...data } : { id: null, title: "", content: "" };
  showForm.value = true;
}

function closeForm() {
  showForm.value = false;
}

function saveArtikel() {
  if (isEdit.value) {
    const idx = artikels.value.findIndex((a) => a.id === form.value.id);
    artikels.value[idx] = { ...form.value };
    showAlert("Artikel berhasil diperbarui");
  } else {
    const id = Date.now();
    artikels.value.push({ ...form.value, id });
    showAlert("Artikel baru berhasil ditambahkan");
  }
  showForm.value = false;
}

function deleteArtikel(id) {
  if (confirm("Hapus artikel ini?")) {
    artikels.value = artikels.value.filter((a) => a.id !== id);
    showAlert("Artikel berhasil dihapus", "error");
  }
}
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
