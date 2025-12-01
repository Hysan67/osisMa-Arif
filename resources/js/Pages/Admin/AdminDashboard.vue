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
          to="/admin/event-form"
          class="flex items-center gap-3 p-3 rounded-md hover:bg-blue-700 transition"
          active-class="bg-blue-800"
        >
          <i class="fa-solid fa-calendar-days text-lg w-5 text-white"></i>
          <i class="fas fa-table w-5"></i>
          <span>Kelola Event</span>
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
          class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-md flex items-center justify-center gap-2"
        >
          <i class="fa-solid fa-right-from-bracket"></i>
      <div class="p-4 border-t border-blue-700">
        <button
          @click="handleLogout"
          class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-md"
        >
          Logout
        </button>
      </div>
    </aside>

    <!-- KONTEN ADMIN -->
    <main class="flex-1 ml-64 p-6">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { onMounted } from 'vue'

const router = useRouter()

function handleLogout() {
  localStorage.removeItem('admin_token')
  router.push('/login')
}

// ANTI KEMBALI KE LOGIN SAAT TEKAN BACK
onMounted(() => {
  // kunci history agar tidak bisa kembali
  window.history.pushState(null, '', window.location.href)
  window.addEventListener('popstate', () => {
    window.history.pushState(null, '', window.location.href)
  })
})
</script>

import { useRouter } from 'vue-router';
import { useAuthStore } from '@/store/useAuthStore.js'

const router = useRouter();
const authStore = useAuthStore()

const handleLogout = async () => {
  await authStore.logout();
  router.push({ name: 'Login' });
};

</script>
