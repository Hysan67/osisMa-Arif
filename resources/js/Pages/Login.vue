<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-300 to-blue-200 px-4 sm:px-6 md:px-0">
    <div class="bg-white/80 backdrop-blur-xl p-8 rounded-2xl shadow-xl w-full max-w-sm sm:max-w-md md:max-w-lg 
            border border-white/50">

      
      <h2 class="text-3xl font-bold text-center mb-6 text-gray-800 tracking-wide">
        Login
      </h2>

      <form @submit.prevent="handleLogin" class="space-y-5">
        
        <!-- EMAIL -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
          />
        </div>

        <!-- PASSWORD -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <div class="relative">
            <input
              id="password"
              :type="showPassword ? 'text' : 'password'"
              v-model="form.password"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
            />

            <!-- Eye Icon -->
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700"
            >
              <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>

              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.219-3.592M6.22 6.228A9.956 9.956 0 0112 5c4.477 0 8.267 2.943 9.542 7a9.985 9.985 0 01-4.171 5.568M3 3l18 18"/>
              </svg>
            </button>
          </div>

          <!-- Extra Links -->
          <div class="flex justify-between text-sm mt-2">
            <button class="text-blue-600 hover:underline" type="button">Lupa sandi?</button>
            <a
              :href="whatsappUrl"
              target="_blank"
              class="text-blue-600 hover:underline"
            >Bantuan</a>
          </div>
        </div>

        <!-- LOGIN BUTTON -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 transition disabled:opacity-50"
        >
          {{ loading ? 'Logging in...' : 'Login' }}
        </button>
      </form>

      <!-- Error -->
      <p v-if="error" class="mt-4 text-red-600 text-center">{{ error }}</p>

      <p class="mt-6 text-center">
        <router-link to="/" class="text-blue-600 hover:underline">
          Kembali ke beranda ←
        </router-link>
      </p>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const form = ref({
  email: 'admin@example.com',
  password: 'password123'
})

const loading = ref(false)
const error = ref('')
const showPassword = ref(false)

const whatsappNumber = "6285755924627"
const whatsappText = "Permisi, saya perlu bantuan."
const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(whatsappText)}`

async function handleLogin() {
  try {
    const response = await axios.post('/login', {
      email: email.value,
      password: password.value
    });

    const { user, token } = response.data;

    // Simpan token dan user ke localStorage
    localStorage.setItem('token', token);
    localStorage.setItem('user', JSON.stringify(user));

    router.push('/admin/member-osis'); // atau halaman lain
  } catch (err) {
    error.value = err.response?.data?.message || 'Login gagal';
  }
}
</script>
