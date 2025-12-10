<template>
  <div class="max-w-2xl mx-auto p-6 py-24">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📧 Kirim Aspirasi ke OSIS</h2>
        <p class="text-gray-600 mt-2">Sampaikan aspirasi Anda. Balasan akan dikirim via email.</p>
      </div>
      
      <form @submit.prevent="submitAspirasi" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Nama Lengkap *
            </label>
            <input v-model="form.nama" type="text" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Kelas
            </label>
            <input v-model="form.kelas" type="text"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                   placeholder="Contoh: XII IPA 1">
          </div>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Email *
            <span class="text-xs text-gray-500">(untuk menerima balasan)</span>
          </label>
          <input v-model="form.email" type="email" required
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Judul Aspirasi *
          </label>
          <input v-model="form.judul" type="text" required
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                 placeholder="Contoh: Usulan perbaikan fasilitas olahraga">
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Isi Aspirasi *
            <span class="text-xs text-gray-500">(maksimal 2000 karakter)</span>
          </label>
          <textarea v-model="form.pesan" rows="6" required maxlength="2000"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Tuliskan aspirasi, saran, atau kritik Anda secara detail..."></textarea>
          <div class="text-right text-xs text-gray-500 mt-1">
            {{ form.pesan.length }}/2000 karakter
          </div>
        </div>
        
        <!-- Success Message -->
        <div v-if="successMessage" class="p-4 bg-green-50 border border-green-200 rounded-lg">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-green-700">{{ successMessage }}</p>
          </div>
        </div>
        
        <!-- Error Message -->
        <div v-if="errorMessage" class="p-4 bg-red-50 border border-red-200 rounded-lg">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
              <p class="text-red-700 font-medium">Gagal mengirim aspirasi</p>
              <p class="text-red-600 text-sm">{{ errorMessage }}</p>
            </div>
          </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end">
          <button type="submit" :disabled="submitting"
                  class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center disabled:opacity-50">
            <svg v-if="submitting" class="animate-spin w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            {{ submitting ? 'Mengirim...' : 'Kirim Aspirasi' }}
          </button>
        </div>
      </form>
    </div>
    
    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
      <div class="flex items-start">
        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
          <h3 class="font-medium text-blue-900">📋 Informasi Pengiriman Aspirasi</h3>
          <ul class="text-sm text-blue-800 mt-2 space-y-1">
            <li>✓ Aspirasi akan dibalas via email dalam 1-3 hari kerja</li>
            <li>✓ Pastikan email yang Anda masukkan aktif dan benar</li>
            <li>✓ Gunakan bahasa yang sopan dan konstruktif</li>
            <li>✓ Data pribadi Anda akan dijaga kerahasiaannya</li>
            <li>✓ Periksa folder spam jika belum menerima balasan</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
  nama: '',
  kelas: '',
  email: '',
  judul: '',
  pesan: ''
})

const submitting = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

async function submitAspirasi() {
  submitting.value = true
  successMessage.value = ''
  errorMessage.value = ''
  
  try {
    const response = await axios.post('/aspirasi', form.value)
    
    if (response.data.success) {
      successMessage.value = response.data.message
      // Reset form
      form.value = {
        nama: '',
        kelas: '',
        email: '',
        judul: '',
        pesan: ''
      }
    }
  } catch (error) {
    if (error.response?.data?.errors) {
      const errors = Object.values(error.response.data.errors).flat()
      errorMessage.value = errors.join(', ')
    } else {
      errorMessage.value = 'Gagal mengirim aspirasi. Silakan coba lagi.'
    }
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>