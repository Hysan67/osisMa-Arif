<template>
   <div class="flex flex-col min-h-screen relative overflow-hidden">
     <!-- Animated Background -->
     <div class="fixed inset-0 -z-10">
       <!-- Gradient Background -->
       <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50"></div>
       
       <!-- Glass Morphism Blobs -->
       <div class="absolute top-10 left-10 w-72 h-72 bg-gradient-to-r from-blue-400/20 to-blue-300/20 rounded-full blur-3xl animate-float-slow"></div>
       <div class="absolute top-40 right-20 w-96 h-96 bg-gradient-to-r from-yellow-400/15 to-yellow-200/15 rounded-full blur-3xl animate-float-medium"></div>
       <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-gradient-to-r from-purple-200/15 to-pink-200/15 rounded-full blur-3xl animate-float-slow"></div>
       
       <!-- Grid Pattern Overlay -->
       <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.1)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.1)_1px,transparent_1px)] bg-[size:64px_64px] [mask-image:radial-gradient(ellipse_80%_50%_at_50%_50%,black,transparent)]"></div>
     </div>
 
     <!-- Navbar -->
     <Navbar v-if="!isAdminPage" />
 
     <!-- Router View -->
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
 import Navbar from './components/layout/Navbar.vue'
 import Footer from './components/layout/Footer.vue'
 
 const route = useRoute()
 
 const isAdminPage = computed(() => {
   return route.path.startsWith('/admin') || route.name === 'Login'
 })
 </script>
 
 <style scoped>
 /* Styles tetap sama */
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
 
 html {
   scroll-behavior: smooth;
 }
 </style>