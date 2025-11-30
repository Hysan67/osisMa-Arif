<template>
  <div class="flex flex-col min-h-screen relative overflow-hidden bg-white dark:bg-gray-900 dark:text-gray-100 transition">

    <!-- Navbar -->
    <Navbar v-if="!isAdminPage" />
<button
  @click="toggleDark"
  class="fixed top-4 right-4 z-50 px-3 py-2 rounded-lg shadow bg-gray-200 dark:bg-gray-700 dark:text-white transition"
>
  🌙 / ☀️
</button>

    <!-- HANYA <router-view /> tanpa container -->
    <main class="flex-1 relative z-10">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </main>

    <!-- Footer -->
    <Footer v-if="!isAdminPage" />
  </div>
</template>

<script setup>
 import { computed } from 'vue'
 import { useRoute } from 'vue-router'
 import Navbar from '@/Layouts/Navbar.vue'
 import Footer from '@/Layouts/Footer.vue'
 
 const route = useRoute()

const isAdminPage = computed(() => {
  return route.path.startsWith('/admin') || route.name === 'Login'
})
export default {
  mounted() {
    // apply theme from localStorage saat website dibuka
    if (localStorage.theme === 'dark') {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }
  },
  methods: {
    toggleDark() {
      const html = document.documentElement
      html.classList.toggle('dark')

      localStorage.theme = html.classList.contains('dark')
        ? 'dark'
        : 'light'
    }
  }
}
</script>

<style>
body {
  @apply bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100;
  overflow-x: hidden;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s, transform 0.5s;
}
.fade-enter-from {
  opacity: 0;
  transform: translateY(20px);
}
.fade-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

/* Custom animations for background elements */
@keyframes float-slow {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}

@keyframes float-medium {
  0%, 100% { transform: translateX(0px) translateY(0px); }
  33% { transform: translateX(10px) translateY(-15px); }
  66% { transform: translateX(-5px) translateY(10px); }
}

.animate-float-slow {
  animation: float-slow 20s ease-in-out infinite;
}

.animate-float-medium {
  animation: float-medium 15s ease-in-out infinite;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}
</style>