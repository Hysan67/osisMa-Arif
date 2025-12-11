import { createApp } from 'vue'
import { createPinia } from 'pinia'
import '../css/app.css'  // Sesuaikan path CSS
import AOS from 'aos'
import 'aos/dist/aos.css'
import App from './app.vue'
import router from './Router/index.js'
import { useAuthStore } from './store/useAuthStore.js'

import axios from 'axios';

// Set default base URL
axios.defaults.baseURL = '/api';

// Interceptor untuk menyisipkan token
axios.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

// Interceptor untuk menangani error 401 (Unauthorized)
axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      // Hapus token dan redirect ke login
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      // this.$router.push('/login'); // Gunakan router.push jika di dalam komponen
    }
    return Promise.reject(error);
  }
);

const app = createApp(App)

// Konfigurasi AOS
app.config.globalProperties.$AOS = AOS
app.mixin({
  mounted() {
    AOS.init({
      duration: 800,
      once: false, 
      easing: 'ease-out-cubic',
      offset: 50,
    })
  },
})

// Scroll ke atas setiap kali ganti halaman
router.afterEach(() => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
  AOS.refresh()
})

app.use(createPinia())
app.use(router)

// Inisialisasi autentikasi saat app start
const authStore = useAuthStore()
authStore.checkAuth()

document.title = 'OSIS MA Ma’arif Udanawu';

app.mount('#app')