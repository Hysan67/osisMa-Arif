import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('auth_token'))

  const isAuthenticated = computed(() => !!token.value)

  const login = async (email, password) => {
    try {
      // SEMENTARA: Simulasi login tanpa API
      // Nanti ganti dengan call ke Laravel backend
      
      if (email === 'admin@osis.com' && password === 'password') {
        user.value = { 
          id: 1, 
          name: 'Admin OSIS', 
          email: email,
          role: 'admin'
        }
        token.value = 'fake-jwt-token-for-development'
        localStorage.setItem('auth_token', token.value)
        return { success: true, user: user.value }
      } else {
        throw new Error('Email atau password salah')
      }
    } catch (error) {
      throw error
    }
  }

  const logout = () => {
    user.value = null
    token.value = null
    localStorage.removeItem('auth_token')
  }

  const checkAuth = () => {
    // Check if token exists in localStorage
    const savedToken = localStorage.getItem('auth_token')
    if (savedToken) {
      user.value = { 
        id: 1, 
        name: 'Admin OSIS', 
        email: 'admin@osis.com',
        role: 'admin'
      }
      token.value = savedToken
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    login,
    logout,
    checkAuth
  }
})