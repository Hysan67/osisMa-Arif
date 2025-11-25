import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import '../css/app.css'  // Sesuaikan path CSS
import AOS from 'aos'
import 'aos/dist/aos.css'
import { useAuthStore } from './stores/authStore' // Sesuaikan path store

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

app.mount('#app')