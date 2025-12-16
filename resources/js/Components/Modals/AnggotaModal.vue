<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <!-- Modal Header -->
      <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">
          {{ isEdit ? 'Edit Anggota' : 'Tambah Anggota Baru' }}
        </h2>
        <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-6">
        <form @submit.prevent="handleSubmit">
          <!-- Two Column Layout -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
              <!-- Nama -->
              <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap *</label>
                <input
                  v-model="localForm.nama"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Nama anggota"
                />
              </div>

              <!-- Posisi -->
              <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Posisi/Jabatan *</label>
                <select
                  v-model="localForm.posisi"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">Pilih Posisi</option>
                  <option v-for="posisi in posisiOptions" :key="posisi" :value="posisi">
                    {{ posisi }}
                  </option>
                </select>
              </div>

              <!-- Bidang -->
              <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Bidang</label>
                <select
                  v-model="localForm.bidang_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">Pilih Bidang</option>
                  <option v-for="bidang in bidangs" :key="bidang.id" :value="bidang.id">
                    {{ bidang.nama }}
                  </option>
                </select>
              </div>

              <!-- Status -->
              <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Status *</label>
                <div class="flex space-x-4">
                  <label class="inline-flex items-center">
                    <input
                      type="radio"
                      v-model="localForm.status"
                      value="aktif"
                      required
                      class="text-blue-600 focus:ring-blue-500"
                    />
                    <span class="ml-2">Aktif</span>
                  </label>
                  <label class="inline-flex items-center">
                    <input
                      type="radio"
                      v-model="localForm.status"
                      value="non aktif"
                      required
                      class="text-blue-600 focus:ring-blue-500"
                    />
                    <span class="ml-2">Non Aktif</span>
                  </label>
                </div>
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
              <!-- Kelas -->
              <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Kelas</label>
                <input
                  v-model="localForm.kelas"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Contoh: XII IPA 1"
                />
              </div>

              <!-- Gambar -->
              <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Foto Anggota</label>
                <div class="mt-1">
                  <!-- Image Preview -->
                  <div v-if="localForm.imgPreview" class="mb-3">
                    <img :src="localForm.imgPreview" class="h-40 w-full object-cover rounded-lg border border-gray-300" />
                  </div>
                  
                  <!-- Upload Button -->
                  <div class="flex items-center space-x-3">
                    <label class="cursor-pointer flex-1">
                      <input
                        type="file"
                        ref="fileInput"
                        @change="handleFileChange"
                        accept="image/*"
                        class="hidden"
                      />
                      <div class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-center hover:bg-gray-50 transition">
                        <svg class="w-6 h-6 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">
                          {{ localForm.imgPreview ? 'Ganti Foto' : 'Unggah Foto' }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Klik untuk memilih file</p>
                      </div>
                    </label>
                    
                    <!-- Remove Button -->
                    <button
                      v-if="localForm.imgPreview"
                      @click="removeImage"
                      type="button"
                      class="px-4 py-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition"
                      title="Hapus Foto"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>
                </div>
                <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
              </div>
            </div>
          </div>

          <!-- Pengalaman & Prestasi -->
          <div class="mt-6">
            <label class="block text-gray-700 text-sm font-medium mb-2">Pengalaman & Prestasi</label>
            <textarea
              v-model="localForm.pengalaman_prestasi"
              rows="4"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Deskripsi pengalaman dan prestasi anggota"
            ></textarea>
          </div>

          <!-- Error Message -->
          <div v-if="submitError" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-sm text-red-600">{{ submitError }}</p>
          </div>

          <!-- Modal Footer -->
          <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
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
</template>

<script setup>
import { ref, reactive, watch, onMounted } from "vue";

const props = defineProps({
  show: Boolean,
  isEdit: Boolean,
  formData: Object,
  bidangs: {
    type: Array,
    default: () => []
  }
});

const emit = defineEmits(['save', 'close']);

const posisiOptions = [
  'Ketua Umum',
  'Ketua',
  'Sekretaris Umum',
  'Sekretaris',
  'Bendahara Umum',
  'Bendahara',
  'Ketua Departemen',
  'Anggota'
];

// Local form state
const localForm = reactive({
  id: null,
  nama: "",
  posisi: "",
  kelas: "",
  bidang_id: "",
  status: "aktif",
  pengalaman_prestasi: "",
  img: null,
  imgPreview: null,
});

// State
const submitting = ref(false);
const submitError = ref("");
const fileInput = ref(null);

// Watch for formData changes
watch(() => props.formData, (newData) => {
  if (newData && Object.keys(newData).length > 0) {
    // Reset form dulu
    resetForm();
    
    // Isi form dengan data baru
    Object.keys(localForm).forEach(key => {
      if (key in newData && newData[key] !== undefined) {
        localForm[key] = newData[key];
      }
    });
    
    // Handle image preview khusus
    if (newData.imgPreview) {
      localForm.imgPreview = newData.imgPreview;
    } else if (newData.img) {
      // Jika ada img tapi tidak ada imgPreview, buat preview dari URL yang ada
      if (typeof newData.img === 'string' && (newData.img.startsWith('http') || newData.img.startsWith('/'))) {
        localForm.imgPreview = newData.img;
      }
    }
  }
}, { immediate: true });

// Reset form when modal closes
watch(() => props.show, (newVal) => {
  if (!newVal) {
    resetForm();
  }
});

// Methods
function resetForm() {
  Object.assign(localForm, {
    id: null,
    nama: "",
    posisi: "",
    kelas: "",
    bidang_id: "",
    status: "aktif",
    pengalaman_prestasi: "",
    img: null,
    imgPreview: null,
  });
  submitError.value = "";
  submitting.value = false;
}

function handleFileChange(event) {
  const file = event.target.files[0];
  if (file) {
    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!validTypes.includes(file.type)) {
      submitError.value = 'Format file harus JPG, PNG, atau GIF';
      return;
    }
    
    // Check file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
      submitError.value = 'Ukuran file maksimal 2MB';
      return;
    }
    
    localForm.img = file;
    const reader = new FileReader();
    reader.onload = (e) => {
      localForm.imgPreview = e.target.result;
    };
    reader.readAsDataURL(file);
    submitError.value = "";
  }
}

function removeImage() {
  localForm.img = null;
  localForm.imgPreview = null;
  if (fileInput.value) {
    fileInput.value.value = "";
  }
}

function closeModal() {
  emit('close');
}

async function handleSubmit() {
  submitting.value = true;
  submitError.value = "";
  
  try {
    // Basic validation
    if (!localForm.nama.trim()) {
      throw new Error("Nama wajib diisi");
    }
    
    if (!localForm.posisi) {
      throw new Error("Posisi wajib dipilih");
    }
    
    // Prepare form data
    const formData = new FormData();
    
    // Append all form data except imgPreview
    Object.keys(localForm).forEach(key => {
      if (key !== 'imgPreview' && localForm[key] !== null && localForm[key] !== undefined) {
        if (key === 'bidang_id' && !localForm[key]) {
          formData.append(key, '');
        } else if (key === 'pengalaman_prestasi' && !localForm[key]) {
          formData.append(key, '-');
        } else if (key === 'kelas' && !localForm[key]) {
          formData.append(key, '-');
        } else {
          formData.append(key, localForm[key]);
        }
      }
    });
    
    // Handle image file
    if (localForm.img instanceof File) {
      formData.append('img', localForm.img);
    }
    
    // Emit save event with form data
    emit('save', formData);
    
  } catch (error) {
    console.error("Validation error:", error);
    submitError.value = error.message || "Terjadi kesalahan validasi";
  } finally {
    submitting.value = false;
  }
}
</script>

<style scoped>
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
</style>