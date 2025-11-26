// resources/js/stores/useAuthStore.js
import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('auth_token'))

  const isAuthenticated = computed(() => !!token.value)

  const login = async (email, password) => {
    console.log('🔄 AuthStore login called with:', email, password)
    
    // Demo login - always success
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        if (email && password) {
          user.value = { 
            id: 1, 
            name: 'Admin OSIS', 
            email: email,
            role: 'admin'
          }
          token.value = 'demo-token-' + Date.now()
          localStorage.setItem('auth_token', token.value)
          console.log('✅ Login successful')
          resolve({ success: true, user: user.value })
        } else {
          console.log('❌ Login failed')
          reject(new Error('Email dan password required'))
        }
      }, 1000)
    })
  }

  const logout = () => {
    user.value = null
    token.value = null
    localStorage.removeItem('auth_token')
  }

  const checkAuth = () => {
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