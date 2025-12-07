<template>
  <div class="min-h-screen flex bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 h-screen overflow-y-auto bg-[#1E40AF] text-white flex flex-col fixed z-50">
      <div class="text-center py-6 text-2xl font-semibold border-b border-blue-700">
        OSIS Admin
      </div>

      <nav class="flex-1 px-4 py-6 space-y-2">
        <router-link
          to="/admin/kelola-artikel"
          class="flex items-center gap-3 p-3 rounded-md hover:bg-blue-700 transition"
          active-class="bg-blue-800"
        >
          <i class="fa-solid fa-newspaper text-lg w-5 text-white"></i>
          <i class="fas fa-newspaper w-5"></i>
          <span>Kelola Artikel</span>
        </router-link>
        
        <router-link
          to="/admin/member-osis"
          class="flex items-center gap-3 p-3 rounded-md hover:bg-blue-700 transition"
          active-class="bg-blue-800"
        >
          <i class="fa-solid fa-users text-lg w-5 text-white"></i>
          <i class="fas fa-users w-5"></i>
          <span>Member OSIS</span>
        </router-link>
      </nav>

      <!-- Logout -->
      <div class="p-4 border-t border-blue-700">
        <button
          @click="handleLogout"
          class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-md"
        >
          Logout
        </button>
        <div v-if="message" class="mt-2 text-center text-sm text-green-300">
          {{ message }}
        </div>
      </div>
    </aside>

    <!-- KONTEN ADMIN -->
    <main class="flex-1 ml-64 p-6">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const message = ref('')

async function handleLogout() {
  try {
    await axios.post('http://localhost:8000/api/logout'); // Token akan dikirim oleh interceptor
  } catch (err) {
    console.error('Logout error:', err);
    // Jika logout gagal, tetap hapus lokal
  }

  localStorage.removeItem('token');
  localStorage.removeItem('user');
  router.push('/login');
}
</script>
apakah seperti ini?