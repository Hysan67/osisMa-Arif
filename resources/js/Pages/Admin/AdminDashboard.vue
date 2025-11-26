<template>
  <div class="min-h-screen flex bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#1E40AF] text-white flex flex-col">
      <div class="text-center py-6 text-2xl font-semibold border-b border-blue-700">
        OSIS Admin
      </div>

      <nav class="flex-1 px-4 py-6 space-y-2">
        <router-link
            to="/admin/kelola-artikel"
              class="flex items-center gap-3 p-3 rounded-md hover:bg-blue-700 transition"
              active-class="bg-blue-800"
      >
            <i class="fas fa-newspaper w-5"></i>
            <span>Kelola Artikel</span>
          </router-link>

          <router-link
          to="/admin/event-form"
            class="flex items-center gap-3 p-3 rounded-md hover:bg-blue-700 transition"
            active-class="bg-blue-800"
      >
            <i class="fas fa-table w-5"></i>
            <span>Kelola Event</span>
            </router-link>

          <router-link
            to="/admin/member-osis"
            class="flex items-center gap-3 p-3 rounded-md hover:bg-blue-700 transition"
            active-class="bg-blue-800"
      >
            <i class="fas fa-users w-5"></i>
            <span>Member OSIS</span>
            </router-link>
      </nav>

      <div class="p-4 border-t border-blue-700">
        <button
          @click="handleLogout"
          class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-md"
        >
          Logout
        </button>
      </div>
    </aside>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../store/useAuthStore'

const router = useRouter()
const authStore = useAuthStore()

// Data event
const events = ref([
  { id: 1, title: 'Lomba Kebersihan', date: '2025-03-15', desc: 'Event kebersihan antar kelas.' },
  { id: 2, title: 'Pentas Seni', date: '2025-05-10', desc: 'Menampilkan kreativitas siswa.' },
])

// Modal form
const showForm = ref(false)
const isEdit = ref(false)
const loading = ref(false)
const form = ref({
  id: null,
  title: '',
  date: '',
  desc: ''
})

function openForm(event = null) {
  if (event) {
    isEdit.value = true
    form.value = { ...event }
  } else {
    isEdit.value = false
    form.value = { id: null, title: '', date: '', desc: '' }
  }
  showForm.value = true
}

function closeForm() {
  showForm.value = false
  loading.value = false
}

function submitForm() {
  loading.value = true

  if (isEdit.value) {
    const index = events.value.findIndex(e => e.id === form.value.id)
    if (index !== -1) events.value[index] = { ...form.value }
  } else {
    const newId = events.value.length ? Math.max(...events.value.map(e => e.id)) + 1 : 1
    events.value.push({ ...form.value, id: newId })
  }

  setTimeout(() => {
    loading.value = false
    showForm.value = false
  }, 400)
}

function deleteEvent(id) {
  if (confirm('Yakin ingin menghapus event ini?')) {
    events.value = events.value.filter(e => e.id !== id)
  }
}

function handleLogout() {
  authStore.logout()
  router.push('/login')
}
</script>

<style scoped>
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css");
</style>


