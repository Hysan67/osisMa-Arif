<template>
  <div class="min-h-screen flex bg-gray-50 w-full overflow-hidden">

    <!-- Tombol Menu (Mobile) -->
    <button
      @click="sidebarOpen = !sidebarOpen"
      class="lg:hidden fixed top-4 right-4 z-50 bg-blue-700 text-white p-2 rounded-md shadow-md"
    >
      ☰
    </button>

    <!-- Sidebar -->
    <aside
      class="w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-white shadow-xl fixed h-full z-50
         transform lg:translate-x-0 transition-transform duration-300 overflow-x-auto"
      :class="{
      '-translate-x-full': !sidebarOpen,
      'translate-x-0': sidebarOpen
    }"
    >
      <div class="flex items-center justify-center h-20 border-b border-blue-700/50">
        <div class="flex items-center space-x-3">
          <div>
            <h1 class="text-xl font-bold tracking-tight">OSIS Admin</h1>
            <p class="text-xs text-blue-300">Management System</p>
          </div>
        </div>
      </div>
      
      <!-- Navigation Menu -->
      <nav class="px-4 py-6 space-y-1">
        
        <!-- Member OSIS -->
        <router-link
          to="/admin/member-osis"
          class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group"
          :class="{
            'bg-blue-700 shadow-lg': $route.path === '/admin/member-osis',
            'hover:bg-blue-700/50': $route.path !== '/admin/member-osis'
          }"
        >
          <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600/20 group-hover:bg-blue-600/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.67 3.623a10 10 0 01-.67 3.376"/>
            </svg>
          </div>
          <span class="font-medium">Member OSIS</span>
          <div v-if="$route.path === '/admin/member-osis'" class="ml-auto w-2 h-2 bg-blue-300 rounded-full"></div>
        </router-link>

        <!-- Kelola Bidang -->
        <router-link
          to="/admin/kelola-bidang"
          class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group"
          :class="{
            'bg-blue-700 shadow-lg': $route.path === '/admin/kelola-bidang',
            'hover:bg-blue-700/50': $route.path !== '/admin/kelola-bidang'
          }"
        >
          <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600/20 group-hover:bg-blue-600/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <span class="font-medium">Kelola Bidang</span>
          <div v-if="$route.path === '/admin/kelola-bidang'" class="ml-auto w-2 h-2 bg-blue-300 rounded-full"></div>
        </router-link>

        <!-- Kelola Artikel -->
        <router-link
          to="/admin/kelola-artikel"
          class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group"
          :class="{
            'bg-blue-700 shadow-lg': $route.path === '/admin/kelola-artikel',
            'hover:bg-blue-700/50': $route.path !== '/admin/kelola-artikel'
          }"
        >
          <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600/20 group-hover:bg-blue-600/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
          </div>
          <span class="font-medium">Kelola Artikel</span>
          <div v-if="$route.path === '/admin/kelola-artikel'" class="ml-auto w-2 h-2 bg-blue-300 rounded-full"></div>
        </router-link>

        <!-- Kelola Aspirasi -->
        <router-link
          to="/admin/kelola-aspirasi"
          class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group"
          :class="{
            'bg-blue-700 shadow-lg': $route.path === '/admin/kelola-aspirasi',
            'hover:bg-blue-700/50': $route.path !== '/admin/kelola-aspirasi'
          }"
        >
          <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600/20 group-hover:bg-blue-600/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
            </svg>
          </div>
          <span class="font-medium">Kelola Aspirasi</span>
          <div v-if="$route.path === '/admin/kelola-aspirasi'" class="ml-auto w-2 h-2 bg-blue-300 rounded-full"></div>
        </router-link>

        <!-- Pendaftaran OSIS -->
        <router-link
          to="/admin/kelola-pendaftaran"
          class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group"
          :class="{
            'bg-blue-700 shadow-lg': $route.path === '/admin/kelola-pendaftaran',
            'hover:bg-blue-700/50': $route.path !== '/admin/kelola-pendaftaran'
          }"
        >
          <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600/20 group-hover:bg-blue-600/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <span class="font-medium">Pendaftaran OSIS</span>
          <!-- Badge untuk pending count -->
          <span v-if="pendingCount > 0" 
                class="ml-auto bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded-full min-w-[20px] h-5 flex items-center justify-center">
            {{ pendingCount }}
          </span>
          <div v-if="$route.path === '/admin/kelola-pendaftaran'" class="ml-auto w-2 h-2 bg-blue-300 rounded-full"></div>
        </router-link>

      </nav>

      <!-- Logout -->
      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-700/50 bg-blue-900/30">
        <button
          @click="handleLogout"
          class="w-full flex items-center justify-center space-x-2 bg-gradient-to-r from-red-600 to-red-700 
                 hover:from-red-700 hover:to-red-800 text-white py-3 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          <span class="font-medium">Logout</span>
        </button>

        <div v-if="message" class="mt-3 p-2 bg-green-500/20 border border-green-500/30 rounded-lg">
          <p class="text-xs text-center text-green-300">{{ message }}</p>
        </div>
      </div>
    </aside>

    <!-- Overlay (Mobile) -->
    <div
      v-if="sidebarOpen"
      @click="sidebarOpen = false"
      class="fixed inset-0 bg-black bg-opacity-40 lg:hidden z-40"
    ></div>


    <!-- Main Content -->
    <main class="flex-1 lg:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 overflow-x-auto">
      <div v-if="$route.path !== '/admin'" class="p-4 bg-white shadow-sm border-b ">
        <button
          @click="goToHome"
          class="flex items-center space-x-2 text-blue-600 hover:text-blue-800 font-medium"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span>Kembali ke Beranda</span>
        </button>
      </div>
      <div class="p-8">
        <router-view />
      </div>
    </main>
 
  </div>
</template>



<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()

const message = ref('')
const user = ref(null)
const sidebarOpen = ref(false)
const pendingCount = ref(0)

onMounted(() => {
  const userData = localStorage.getItem('user')
  if (userData) user.value = JSON.parse(userData)
  fetchPendingCount()
})

// Watch route changes to close sidebar on mobile
watch(route, () => {
  if (window.innerWidth < 1024) {
    sidebarOpen.value = false
  }
})

// Fetch pending registration count
async function fetchPendingCount() {
  try {
    const response = await axios.get('/pendaftaran-osis/stats')
    if (response.data.success) {
      pendingCount.value = response.data.data.pending || 0
    }
  } catch (error) {
    console.error('Error fetching pending count:', error)
  }
}

function goToHome() {
  router.push('/')
}

async function handleLogout() {
  try {
    await axios.post('/logout')
    message.value = 'Logout berhasil!'
    
    setTimeout(() => {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      router.push('/login')
    }, 1000)

  } catch (err) {
    console.error('Logout error:', err)
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    router.push('/login')
  }
}
</script>



<style scoped>
/* Smooth transitions */
.router-link-active {
  position: relative;
}

/* Scrollbar */
aside::-webkit-scrollbar {
  width: 6px;
}
aside::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
}
aside::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 3px;
}
aside::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.5);
}

/* Active indicator dot */
.router-link-active .active-dot {
  opacity: 1;
}
</style>