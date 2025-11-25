<template>
   <div class="min-h-screen flex items-center justify-center bg-gray-100">
     <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
       <h2 class="text-2xl font-bold text-center mb-6">Login Admin</h2>
       <form @submit.prevent="handleLogin">
         <div class="mb-4">
           <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
           <input
             id="email"
             v-model="form.email"
             type="email"
             required
             class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
           />
         </div>
         <div class="mb-6">
           <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
           <input
             id="password"
             v-model="form.password"
             type="password"
             required
             class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
           />
         </div>
         <button
           type="submit"
           :disabled="loading"
           class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
         >
           {{ loading ? 'Logging in...' : 'Login' }}
         </button>
       </form>
       <p v-if="error" class="mt-4 text-red-600 text-center">{{ error }}</p>
     </div>
   </div>
 </template>
 
 <script setup>
 import { ref } from 'vue'
 import { useRouter } from 'vue-router'
 import { useAuthStore } from '../store/useAuthStore'
 
 const router = useRouter()
 const authStore = useAuthStore()
 
 const form = ref({
   email: '',
   password: ''
 })
 const loading = ref(false)
 const error = ref('')
 
 const handleLogin = async () => {
   loading.value = true
   error.value = ''
   try {
     await authStore.login(form.value.email, form.value.password)
     router.push('/admin/dashboard') // Redirect ke dashboard setelah login berhasil
   } catch (err) {
     error.value = 'Login gagal. Periksa email dan password.'
   } finally {
     loading.value = false
   }
 }
 </script>