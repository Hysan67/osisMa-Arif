import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/Pages/Home.vue'
import Event from '@/Pages/Event.vue'
import EventDetail from '@/Pages/EventDetail.vue'
import Generasi from '@/Pages/Generasi.vue'
import BidangDetail from '@/Pages/BidangDetail.vue'
import FormAspirasi from '@/Pages/FormAspirasi.vue'
import Login from '@/Pages/Login.vue'
import EventForm from '@/Pages/Admin/EventForm.vue'
import MemberOsis from '@/Pages/Admin/MemberOsis.vue'
import KelolaArtikel from '@/Pages/Admin/KelolaArtikel.vue'
import AdminDashboard from '@/Pages/Admin/AdminDashboard.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/event', name: 'Event', component: Event },
  { path: '/event/:id', name: 'EventDetail', component: EventDetail },
  { path: '/generasi', name: 'Generasi', component: Generasi },
  { path: '/form-aspirasi-siswa', name: 'FormAspirasi', component: FormAspirasi },
  { 
    path: '/bidang/:id', 
    name: 'BidangDetail', 
    component: BidangDetail,
    props: true
  },
  { path: '/login', name: 'Login', component: Login, meta: { requiresGuest: true } },
  {
    path: '/admin',
    component: AdminDashboard,
    meta: { requiresAuth: true },
    children: [ 
      {
        path: 'event-form',
        name: 'EventForm',
        component: EventForm,
        meta: { requiresAuth: true }
      },
      {
        path: 'kelola-artikel',
        name: 'KelolaArtikel',
        component: KelolaArtikel,
        meta: { requiresAuth: true }
      },
      {
        path: 'member-osis',
        name: 'MemberOsis',
        component: MemberOsis,
        meta: { requiresAuth: true }
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

  if (to.meta.requiresAuth) {
    const isAuthenticated = localStorage.getItem('user') !== null;

    if (isAuthenticated) {
      next()
    } else {
      next({ name: 'Login' })
    }
  }
  else if (to.meta.requiresGuest) {
    const isAuthenticated = localStorage.getItem('user') !== null;

    if (isAuthenticated) {
      next({ name: 'AdminDashboard' })
    } else {
      next()
    }
  }
  else {
    next() // Izinkan akses ke halaman publik
  }
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