<template>
  <div class="max-w-2xl mx-auto p-6 py-24">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Form Pendaftaran OSIS</h2>
        <p class="text-gray-600 mt-2">Silakan lengkapi formulir berikut untuk proses pendaftaran OSIS.</p>
      </div>

      <form @submit.prevent="submitPendaftaran" class="space-y-4">

        <!-- NAMA -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
          <input v-model="form.nama" required type="text"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
``
        <!-- FOTO -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Foto 3x4 *</label>
          <input type="file" accept="image/*" @change="handleFoto" class="w-full text-sm">
          <p class="text-xs text-gray-500 mt-1">Maksimal ukuran file: 2MB</p>
        </div>

        <!-- KELAS -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Kelas *</label>
          <input v-model="form.kelas" required type="text" placeholder="Contoh: X-A"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- TEMPAT LAHIR -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir *</label>
          <input v-model="form.tempat_lahir" required type="text"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- TANGGAL -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
          <input v-model="form.tanggal_lahir" required type="date"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- JENIS KELAMIN -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
          <select v-model="form.jenis_kelamin" required
                  class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">Pilih...</option>
            <option>Laki-laki</option>
            <option>Perempuan</option>
          </select>
        </div>

        <!-- ALAMAT -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
          <textarea v-model="form.alamat" required rows="2"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- HP -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP *</label>
          <input v-model="form.no_hp" required type="text" placeholder="Contoh: 081122334455"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- ASAL SEKOLAH -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Asal Sekolah *</label>
          <input v-model="form.asal_sekolah" required type="text"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- ORTU -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Orang Tua/Wali *</label>
          <input v-model="form.nama_ortu_wali" required type="text"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- PENGALAMAN -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman / Prestasi</label>
          <textarea v-model="form.pengalaman_prestasi" rows="3"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- PENYAKIT -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Penyakit yang Diderita</label>
          <textarea v-model="form.penyakit_diderita" rows="2"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- RUTINITAS -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Rutinitas yang Menghambat</label>
          <textarea v-model="form.rutinitas_menghambat" rows="2"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- TUJUAN -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Masuk OSIS *</label>
          <textarea v-model="form.tujuan" required rows="2"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- HARAPAN -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Harapan Setelah Bergabung *</label>
          <textarea v-model="form.harapan" required rows="2"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- TANGGAL ORTU -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Persetujuan Orang Tua *</label>
          <input v-model="form.tanggal_ortu_wali" required type="date"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- SUBMIT -->
        <div class="flex justify-end">
          <button type="submit" :disabled="submitting"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>

            {{ submitting ? 'Mengirim...' : 'Kirim' }}
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
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
  nama: '',
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

function handleFoto(e) {
  const file = e.target.files[0]
  if (file && file.size > 2 * 1024 * 1024) {
    alert("Ukuran foto maksimal 2MB.")
    e.target.value = null
    return
  }
  form.value.foto = file
}

async function submitPendaftaran() {
  submitting.value = true

  const fd = new FormData()
  for (const key in form.value) {
    fd.append(key, form.value[key])
  }

  try {
    await axios.post('/pendaftaran-osis', fd, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    alert("Pendaftaran berhasil dikirim!")
  } catch (e) {
    alert("Gagal mengirim pendaftaran.")
  }

  submitting.value = false
}
</script>

