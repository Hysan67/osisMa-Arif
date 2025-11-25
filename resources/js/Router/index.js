import { createRouter, createWebHistory } from 'vue-router'
import { createWebHashHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/Home.vue')
  },
  {
    path: '/admin',
    name: 'Admin',
    component: () => import('../views/Admin.vue')
  },
  {
    path: '/login', 
    name: 'Login',
    component: () => import('../views/Login.vue')
  }
  // Tambahkan routes lainnya...
]

const router = createRouter({
  history: createWebHistory(),
  // atau untuk compatibility lebih baik:
  // history: createWebHashHistory(),
  routes
})

export default router