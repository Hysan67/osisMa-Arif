<template>
  <div class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50">
    <div class="bg-white rounded-md shadow-lg max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
      <h3 class="text-xl font-semibold mb-4">{{ isEdit ? "Edit Artikel" : "Artikel Baru" }}</h3>

      <form @submit.prevent="$emit('save')">
        <div class="mb-4">
          <label class="block mb-1 font-medium">Judul</label>
          <input v-model="formData.judul" class="w-full border px-3 py-2 rounded" required />
        </div>

        <div class="mb-4">
          <label class="block mb-1 font-medium">Deskripsi</label>
          <textarea v-model="formData.deskripsi" rows="4" class="w-full border px-3 py-2 rounded" required></textarea>
        </div>

        <div class="mb-4">
          <label class="block mb-1 font-medium">Jenis Artikel</label>
          <select v-model="formData.jenis_artikel" class="w-full border px-3 py-2 rounded" required @change="onJenisArtikelChange">
            <option value="artikel">Artikel</option>
            <option value="event">Event</option>
            <option value="pengumuman">Pengumuman</option>
          </select>
        </div>

        <!-- Field khusus untuk pengumuman -->
        <div v-if="formData.jenis_artikel === 'pengumuman'" class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
          <label class="block mb-2 font-medium text-yellow-800">Pengaturan Pengumuman</label>
          
          <div class="mb-3">
            <label class="block mb-1 text-sm font-medium">Tanggal Kedaluwarsa (Opsional)</label>
            <input 
              type="datetime-local" 
              v-model="formData.expires_at"
              :min="minDateTime"
              class="w-full border px-3 py-2 rounded"
            />
            <p class="text-xs text-gray-500 mt-1">
              Kosongkan jika pengumuman tidak memiliki tanggal kedaluwarsa
            </p>
          </div>

          <div class="flex items-center p-3 bg-yellow-100 rounded border border-yellow-300">
            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-yellow-700">
              Pengumuman akan otomatis tersembunyi setelah tanggal kedaluwarsa
            </p>
          </div>
        </div>

        <div class="mb-4">
          <label class="block mb-1 font-medium">Gambar (Opsional)</label>
          <div v-if="formData.img && formData.img.name" class="mb-3">
            <p class="text-sm text-gray-600 mb-1">File dipilih: {{ formData.img.name }}</p>
            <img v-if="formData.imgPreview" :src="formData.imgPreview" class="w-32 h-32 object-cover rounded border">
          </div>
          <input type="file" @change="$emit('file-upload', $event)" class="w-full border px-3 py-2 rounded" accept="image/*" />
          <p class="text-sm text-gray-500 mt-1">format: jpeg, png, jpg, gif</p>
        </div>

        <div class="flex justify-end space-x-3">
          <button type="button" @click="$emit('close')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
          <button type="submit" class="px-4 py-2 bg-[#1E40AF] text-white rounded hover:bg-[#1E3A8A]">
            {{ isEdit ? "Update" : "Simpan" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
  isEdit: Boolean,
  formData: Object
});

defineEmits(['save', 'close', 'file-upload']);

// Min date untuk datetime-local (sekarang)
const minDateTime = computed(() => {
  const now = new Date();
  // Format: YYYY-MM-DDTHH:mm
  return now.toISOString().slice(0, 16);
});

// Handler ketika jenis artikel berubah
const onJenisArtikelChange = () => {
  // Reset expires_at jika bukan pengumuman
  if (props.formData.jenis_artikel !== 'pengumuman') {
    props.formData.expires_at = null;
  }
};

const validateForm = () => {
  if (formData.value.jenis_artikel === 'pengumuman' && formData.value.expires_at) {
    const expiresDate = new Date(formData.value.expires_at);
    if (expiresDate < new Date()) {
      // Tampilkan error
      return false;
    }
  }
  return true;
};
</script>