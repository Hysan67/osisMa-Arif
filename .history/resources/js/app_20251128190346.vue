<template>
  <div class="flex flex-col min-h-screen relative overflow-hidden">

    <!-- Navbar -->
    <Navbar v-if="!isAdminPage" />

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
</script>

<style>
body {
  @apply bg-gray-50 text-gray-800;
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