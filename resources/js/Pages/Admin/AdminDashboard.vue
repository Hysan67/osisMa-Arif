<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
      <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
      <p class="mb-4">Selamat datang, {{ user?.name || 'Admin' }}!</p>
      <button
        @click="handleLogout"
        class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700"
      >
        Logout
      </button>
      <!-- Tambahkan konten admin lainnya di sini, misalnya link ke EventForm -->
      <div class="mt-6">
        <router-link to="/admin/event-form" class="text-blue-600 hover:underline">Kelola Event</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../store/useAuthStore'

const router = useRouter()
const authStore = useAuthStore()

onMounted(() => {
  authStore.checkAuth() // Periksa autentikasi saat komponen mount
  if (!authStore.isAuthenticated) {
    router.push('/login-admin') // Redirect jika tidak authenticated
  }
})

const handleLogout = () => {
  authStore.logout()
  router.push('/login-admin')
}
</script>