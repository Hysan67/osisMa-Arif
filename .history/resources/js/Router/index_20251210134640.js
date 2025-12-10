import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/Pages/Home.vue'
import Event from '@/Pages/Event.vue'
import EventDetail from '@/Pages/EventDetail.vue'
import Generasi from '@/Pages/Generasi.vue'
import BidangDetail from '@/Pages/BidangDetail.vue'
import AspirasiSection from '@/Pages/AspirasiSection.vue'
import Login from '@/Pages/Login.vue'
import MemberOsis from '@/Pages/Admin/MemberOsis.vue'
import KelolaArtikel from '@/Pages/Admin/KelolaArtikel.vue'
import AdminDashboard from '@/Pages/Admin/AdminDashboard.vue'
import KelolaBidang from '@/Pages/Admin/KelolaBidang.vue'
import Aspirasi from '@/Pages/Admin/KelolaAspirasi.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/event', name: 'Event', component: Event },
  { path: '/event/:id', name: 'EventDetail', component: EventDetail },
  { path: '/generasi', name: 'Generasi', component: Generasi },
  { path: '/form-aspirasi-siswa', name: 'AspirasiSection', component: AspirasiSection },
  { 
    path: '/bidang/:id', 
    name: 'BidangDetail', 
    component: BidangDetail,
    props: true
  },
  { path: '/login', name: 'Login', component: Login, meta: { requiresGuest: true } },
  {
    path: '/admin',
    name: 'Admin',
    component: AdminDashboard,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        redirect: '/admin/member-osis'
      },
      {
        path: 'kelola-artikel',
        name: 'KelolaArtikel',
        component: KelolaArtikel,
        meta: { requiresAuth: true }
      },
      {
        path: 'kelola-bidang',
        name: 'KelolaBidang',
        component: KelolaBidang,
        meta: { requiresAuth: true }
      },
      {
        path: 'member-osis',
        name: 'MemberOsis',
        component: MemberOsis,
        meta: { requiresAuth: true }
      },
      {
        path: 'kelola-aspirasi',
        name: 'KelolaAspirasi',
        component: Aspirasi,
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
      next({ name: 'Admin' })
    } else {
      next()
    }
  }
  else {
    next()
  }
})

router.afterEach((to) => {
  setTimeout(() => {
    const saved = scrollPositions[to.fullPath]
    if (saved !== undefined) {
      window.scrollTo({
        top: saved,
        behavior: 'instant'
      })
    } else {
      window.scrollTo({ top: 0 })
    }
  }, 0)
})

export default router