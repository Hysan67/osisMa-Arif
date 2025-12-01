import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/Pages/Home.vue'  // ← Path diperbaiki
import Event from '@/Pages/Event.vue'
import EventDetail from '@/Pages/EventDetail.vue'
import Galeri from '@/Pages/Galeri.vue'
import Kontak from '@/Pages/Kontak.vue'
import Generasi from '@/Pages/Generasi.vue'
import BidangDetail from '@/Pages/BidangDetail.vue'
import FormAspirasi from '@/Pages/FormAspirasi.vue'
import Login from '@/Pages/Login.vue'
import EventForm from '@/Pages/Event.vue'
import MemberOsis from '@/Pages/Admin/MemberOsis.vue'
import KelolaArtikel from '@/Pages/Admin/KelolaArtikel.vue'
import AdminDashboard from '@/Pages/Admin/AdminDashboard.vue' // ← Pastikan file ini ada
import { useAuthStore } from '@/store/useAuthStore.js' // ← Path diperbaiki

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/event', name: 'Event', component: Event },
  { path: '/event/:id', name: 'EventDetail', component: EventDetail },
  { path: '/galeri', name: 'Galeri', component: Galeri },
  { path: '/kontak', name: 'Kontak', component: Kontak },
  { path: '/generasi', name: 'Generasi', component: Generasi },
  { path: '/form-aspirasi-siswa', name: 'FormAspirasi', component: FormAspirasi },
  { 
    path: '/bidang/:id', 
    name: 'BidangDetail', 
    component: BidangDetail,
    props: true
  },
  { path: '/login', name: 'Login', component: Login },
  {
    path: '/admin',
    component: AdminDashboard,
    beforeEnter: (to, from, next) => {
      const authStore = useAuthStore()
      if (authStore.isAuthenticated) {
        next()
      } else {
        next('/login')
      }
    },
    children: [ 
      {
        path: 'event-form',
        name: 'EventForm',
        component: EventForm
      },
      {
        path: 'kelola-artikel',
        name: 'KelolaArtikel',
        component: KelolaArtikel
      },
      {
        path: 'member-osis',
        name: 'MemberOsis',
        component: MemberOsis
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Simpan posisi scroll per halaman
const scrollPositions = {}

router.beforeEach((to, from, next) => {
  // Simpan scroll dari halaman sebelumnya
  scrollPositions[from.fullPath] = window.scrollY
  next()
})

router.afterEach((to) => {
  // Jika user kembali ke halaman yang sudah pernah dibuka → restore scroll
  setTimeout(() => {
    const saved = scrollPositions[to.fullPath]
    if (saved !== undefined) {
      window.scrollTo({
        top: saved,
        behavior: 'instant'
      })
    } else {
      // Jika halaman baru pertama dikunjungi → scroll ke atas
      window.scrollTo({ top: 0 })
    }
  }, 0)
})

export default router