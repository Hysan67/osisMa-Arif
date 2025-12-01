import { createApp } from 'vue'
import { createPinia } from 'pinia'
import '../css/app.css'  // Sesuaikan path CSS
import AOS from 'aos'
import 'aos/dist/aos.css'
import App from './app.vue'
import router from './Router/index.js'
import { useAuthStore } from './store/useAuthStore.js'

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