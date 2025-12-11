<template>
  <div class="max-w-2xl mx-auto p-6 py-24">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Form Pendaftaran OSIS</h2>
        <p class="text-gray-600 mt-2">Silakan lengkapi formulir berikut untuk proses pendaftaran OSIS.</p>
      </div>

      <!-- Pesan Sukses/Error -->
      <div v-if="successMessage" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ successMessage }}
      </div>
      <div v-if="errorMessage" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        {{ errorMessage }}
      </div>

      <form @submit.prevent="submitPendaftaran" class="space-y-4">

        <!-- NAMA -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
          <input v-model="form.nama" required type="text"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- EMAIL -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
          <input v-model="form.email" required type="email" placeholder="contoh@email.com"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- FOTO -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Foto 3x4 *</label>
          <input type="file" accept="image/*" @change="handleFoto" class="w-full text-sm border border-gray-300 rounded-lg p-2">
          <p v-if="form.foto" class="text-xs text-green-600 mt-1">✓ Foto terpilih: {{ form.foto.name }}</p>
          <p class="text-xs text-gray-500 mt-1">Maksimal ukuran file: 2MB (JPG, JPEG, PNG)</p>
        </div>

        <!-- KELAS -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Kelas *</label>
          <input v-model="form.kelas" required type="text" placeholder="Contoh: X-A"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- TEMPAT LAHIR -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir *</label>
          <input v-model="form.tempat_lahir" required type="text"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- TANGGAL LAHIR -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
          <input v-model="form.tanggal_lahir" required type="date"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- JENIS KELAMIN -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
          <select v-model="form.jenis_kelamin" required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            <option value="">Pilih...</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>

        <!-- ALAMAT -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
          <textarea v-model="form.alamat" required rows="2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
        </div>

        <!-- HP -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP *</label>
          <input v-model="form.no_hp" required type="tel" placeholder="Contoh: 081122334455"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- ASAL SEKOLAH -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Asal Sekolah *</label>
          <input v-model="form.asal_sekolah" required type="text"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- ORTU -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Orang Tua/Wali *</label>
          <input v-model="form.nama_ortu_wali" required type="text"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- PENGALAMAN -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman / Prestasi</label>
          <textarea v-model="form.pengalaman_prestasi" rows="3" placeholder="Opsional: sertakan pengalaman organisasi atau prestasi yang pernah dicapai"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
        </div>

        <!-- PENYAKIT -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Penyakit yang Diderita</label>
          <textarea v-model="form.penyakit_diderita" rows="2" placeholder="Opsional: jika ada, sebutkan penyakit yang sedang diderita"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
        </div>

        <!-- RUTINITAS -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Rutinitas yang Menghambat</label>
          <textarea v-model="form.rutinitas_menghambat" rows="2" placeholder="Opsional: rutinitas yang mungkin menghambat kegiatan OSIS"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
        </div>

        <!-- TUJUAN -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Masuk OSIS *</label>
          <textarea v-model="form.tujuan" required rows="2" placeholder="Jelaskan tujuan Anda ingin bergabung dengan OSIS"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
        </div>

        <!-- HARAPAN -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Harapan Setelah Bergabung *</label>
          <textarea v-model="form.harapan" required rows="2" placeholder="Apa harapan Anda setelah menjadi anggota OSIS?"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
        </div>

        <!-- TANGGAL ORTU -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Persetujuan Orang Tua *</label>
          <input v-model="form.tanggal_ortu_wali" required type="date"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <!-- SUBMIT -->
        <div class="flex justify-end pt-4">
          <button type="submit" :disabled="submitting || !isFormValid"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
            
            <svg v-if="submitting" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            
            <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>

            {{ submitting ? 'Mengirim...' : 'Kirim Pendaftaran' }}
          </button>
        </div>
        
        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
          <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
              <h3 class="font-medium text-blue-900">📋 Informasi Pengiriman Pendaftaran OSIS</h3>
              <ul class="text-sm text-blue-800 mt-2 space-y-1">
                <li>✓ Pengiriman pendaftaran OSIS akan dibalas via email dalam 1-3 hari kerja</li>
                <li>✓ Pastikan email yang Anda masukkan aktif dan benar</li>
                <li>✓ Gunakan bahasa yang sopan dan konstruktif</li>
                <li>✓ Data pribadi Anda akan dijaga kerahasiaannya</li>
                <li>✓ Periksa folder spam jika belum menerima balasan</li>
              </ul>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'

// CSRF Token untuk Laravel
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''

const form = ref({
  nama: '',
  email: '',
  foto: null,
  kelas: '',
  tempat_lahir: '',
  tanggal_lahir: '',
  jenis_kelamin: '',
  alamat: '',
  no_hp: '',
  asal_sekolah: '',
  nama_ortu_wali: '',
  pengalaman_prestasi: '',
  penyakit_diderita: '',
  rutinitas_menghambat: '',
  tujuan: '',
  harapan: '',
  tanggal_ortu_wali: '',
  status: 'pending',
  admin_id: null
})

const submitting = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

// Computed property untuk cek apakah form valid
const isFormValid = computed(() => {
  return form.value.nama &&
         form.value.email &&
         form.value.foto &&
         form.value.kelas &&
         form.value.tempat_lahir &&
         form.value.tanggal_lahir &&
         form.value.jenis_kelamin &&
         form.value.alamat &&
         form.value.no_hp &&
         form.value.asal_sekolah &&
         form.value.nama_ortu_wali &&
         form.value.tujuan &&
         form.value.harapan &&
         form.value.tanggal_ortu_wali
})

function handleFoto(e) {
  const file = e.target.files[0]
  if (!file) {
    form.value.foto = null
    return
  }
  
  // Validasi tipe file
  const validTypes = ['image/jpeg', 'image/jpg', 'image/png']
  if (!validTypes.includes(file.type)) {
    errorMessage.value = "Hanya file JPG, JPEG, atau PNG yang diperbolehkan."
    e.target.value = null
    form.value.foto = null
    setTimeout(() => { errorMessage.value = '' }, 5000)
    return
  }
  
  // Validasi ukuran file
  if (file.size > 2 * 1024 * 1024) {
    errorMessage.value = "Ukuran foto maksimal 2MB."
    e.target.value = null
    form.value.foto = null
    setTimeout(() => { errorMessage.value = '' }, 5000)
    return
  }
  
  form.value.foto = file
  errorMessage.value = ''
}

function validateForm() {
  // Reset error message
  errorMessage.value = ''
  
  // Validasi email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailRegex.test(form.value.email)) {
    errorMessage.value = 'Format email tidak valid'
    return false
  }
  
  // Validasi nomor HP (hanya angka, minimal 10 digit)
  const phoneRegex = /^[0-9]{10,13}$/
  const phoneNumber = form.value.no_hp.replace(/\D/g, '')
  if (!phoneRegex.test(phoneNumber)) {
    errorMessage.value = 'Nomor HP harus 10-13 digit angka'
    return false
  }
  
  // Update nomor HP dengan format bersih
  form.value.no_hp = phoneNumber
  
  // Validasi tanggal lahir tidak lebih dari hari ini
  const today = new Date().toISOString().split('T')[0]
  if (form.value.tanggal_lahir > today) {
    errorMessage.value = 'Tanggal lahir tidak boleh lebih dari hari ini'
    return false
  }
  
  // Validasi tanggal persetujuan orang tua tidak lebih dari hari ini
  if (form.value.tanggal_ortu_wali > today) {
    errorMessage.value = 'Tanggal persetujuan orang tua tidak boleh lebih dari hari ini'
    return false
  }
  
  return true
}

async function submitPendaftaran() {
  // Reset pesan
  successMessage.value = ''
  errorMessage.value = ''
  
  // Validasi form
  if (!validateForm()) {
    return
  }
  
  submitting.value = true

  const fd = new FormData()
  
  // Tambahkan semua field form ke FormData
  for (const key in form.value) {
    if (form.value[key] !== null && form.value[key] !== '') {
      fd.append(key, form.value[key])
    }
  }
  
  // Tambahkan timestamp
  fd.append('created_at', new Date().toISOString())

  try {
    // Kirim ke endpoint
    const response = await axios.post('/api/pendaftaran-osis', fd, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-CSRF-TOKEN': csrfToken
      }
    })
    
    if (response.data.success) {
      successMessage.value = '✅ ' + response.data.message
      
      // Reset form setelah sukses
      resetForm()
      
      // Scroll ke atas untuk melihat pesan sukses
      window.scrollTo({ top: 0, behavior: 'smooth' })
    } else {
      errorMessage.value = '❌ ' + (response.data.message || 'Gagal mengirim pendaftaran')
    }
  } catch (error) {
    console.error('Error:', error)
    
    if (error.response) {
      // Server responded with error status
      const serverError = error.response.data
      errorMessage.value = '❌ ' + (serverError.message || serverError.error || 'Terjadi kesalahan pada server')
      
      // Tampilkan error validasi dari Laravel jika ada
      if (serverError.errors) {
        const errorList = Object.values(serverError.errors).flat().join(', ')
        errorMessage.value += ': ' + errorList
      }
    } else if (error.request) {
      // No response received
      errorMessage.value = '❌ Tidak ada respon dari server. Periksa koneksi internet Anda.'
    } else {
      // Other errors
      errorMessage.value = '❌ ' + (error.message || 'Gagal mengirim pendaftaran')
    }
  } finally {
    submitting.value = false
    
    // Auto-hide error message after 10 seconds
    if (errorMessage.value) {
      setTimeout(() => {
        errorMessage.value = ''
      }, 10000)
    }
  }
}

function resetForm() {
  form.value = {
    nama: '',
    email: '',
    foto: null,
    kelas: '',
    tempat_lahir: '',
    tanggal_lahir: '',
    jenis_kelamin: '',
    alamat: '',
    no_hp: '',
    asal_sekolah: '',
    nama_ortu_wali: '',
    pengalaman_prestasi: '',
    penyakit_diderita: '',
    rutinitas_menghambat: '',
    tujuan: '',
    harapan: '',
    tanggal_ortu_wali: '',
    status: 'pending',
    admin_id: null
  }
  
  // Reset file input
  const fileInput = document.querySelector('input[type="file"]')
  if (fileInput) fileInput.value = ''
}
</script>

<style scoped>
/* Custom scrollbar untuk textarea */
textarea {
  resize: vertical;
  min-height: 80px;
}

/* Style untuk date input */
input[type="date"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  opacity: 0.6;
}

input[type="date"]::-webkit-calendar-picker-indicator:hover {
  opacity: 1;
}

/* Style untuk file input */
input[type="file"] {
  cursor: pointer;
}

input[type="file"]::file-selector-button {
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
  background-color: #f9fafb;
  color: #374151;
  font-weight: 500;
  margin-right: 1rem;
  cursor: pointer;
  transition: all 0.2s;
}

input[type="file"]::file-selector-button:hover {
  background-color: #f3f4f6;
}

/* Tombol submit yang aktif */
button:not(:disabled) {
  cursor: pointer;
}

button:not(:disabled):hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Transisi untuk semua input */
input, select, textarea {
  transition: all 0.2s;
}

input:focus, select:focus, textarea:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
}
</style>