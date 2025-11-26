<template>
  <div class="min-h-screen flex bg-gray-100 relative">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#1E40AF] text-white p-6 flex flex-col">
      <h1 class="font-cursive text-3xl font-semibold mb-8">OSIS Panel</h1>
      <nav class="flex flex-col space-y-2 text-sm">
        <router-link to="#" class="hover:bg-[#3a3a66] px-3 py-2 rounded inline-flex items-center gap-2">
          <span>🏠</span> Dashboard
        </router-link>
        <router-link to="#" class="hover:bg-[#3a3a66] px-3 py-2 rounded inline-flex items-center gap-2">
          <span>🗓️</span> Event
        </router-link>
      </nav>
    </aside>

    <!-- Konten utama -->
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#1E40AF]">Daftar Event</h2>
        <button
          @click="openForm()"
          class="bg-[#1E40AF] hover:bg-[#1E3A8A] text-white px-4 py-2 rounded"
        >
          + Tambah Event Baru
        </button>
      </div>

      <table class="w-full border border-gray-300 rounded overflow-hidden bg-white">
        <thead class="bg-[#E0E7FF] text-[#1E40AF]">
          <tr>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Nama Event</th>
            <th class="py-2 px-4 border-b border-gray-300 text-center w-40">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="event in events"
            :key="event.id"
            class="even:bg-white odd:bg-gray-50"
          >
            <td class="py-2 px-4 border-b border-gray-300">{{ event.title }}</td>
            <td class="py-2 px-4 border-b border-gray-300 text-center space-x-2">
              <button @click="openForm(event)" class="text-blue-600 hover:underline">Edit</button>
              <button @click="deleteEvent(event.id)" class="text-red-600 hover:underline">Hapus</button>
            </td>
          </tr>
          <tr v-if="events.length === 0">
            <td colspan="2" class="py-4 text-center text-gray-500">Belum ada event.</td>
          </tr>
        </tbody>
      </table>

      <!-- Modal Form Event -->
      <div
        v-if="showForm"
        class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50"
      >
        <div class="bg-white rounded-md shadow-lg max-w-lg w-full p-6 relative">
          <h3 class="text-xl font-semibold mb-4">{{ isEdit ? 'Edit Event' : 'Tambah Event Baru' }}</h3>

          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <label class="block mb-1 font-medium text-gray-700">Judul Event</label>
              <input
                v-model="form.title"
                type="text"
                class="w-full border rounded px-3 py-2"
                required
              />
            </div>

            <div class="mb-4">
              <label class="block mb-1 font-medium text-gray-700">Tanggal</label>
              <input
                v-model="form.date"
                type="date"
                class="w-full border rounded px-3 py-2"
                required
              />
            </div>

            <div class="mb-4">
              <label class="block mb-1 font-medium text-gray-700">Deskripsi</label>
              <textarea
                v-model="form.desc"
                rows="4"
                class="w-full border rounded px-3 py-2"
                required
              ></textarea>
            </div>

            <div class="flex justify-end space-x-3">
              <button
                type="button"
                @click="closeForm"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
              >
                Batal
              </button>
              <button
                type="submit"
                class="px-4 py-2 bg-[#1E40AF] text-white rounded hover:bg-[#1E3A8A]"
              >
                {{ isEdit ? 'Update' : 'Simpan' }}
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- 🔔 ALERT CRUD -->
      <transition name="fade-slide">
        <div
          v-if="alert.show"
          class="fixed bottom-6 right-6 px-4 py-3 rounded-lg shadow-lg text-white font-medium z-[9999]"
          :class="alert.color"
        >
          {{ alert.message }}
        </div>
      </transition>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const events = ref([
  { id: 1, title: 'Event 1', date: '2024-01-10', desc: 'Deskripsi event 1' },
  { id: 2, title: 'Event 2', date: '2024-02-15', desc: 'Deskripsi event 2' }
])

const showForm = ref(false)
const isEdit = ref(false)
const loading = ref(false)
const form = ref({ id: null, title: '', date: '', desc: '' })

// ALERT SYSTEM (langsung di sini)
const alert = ref({
  show: false,
  message: '',
  color: 'bg-green-500'
})

function showAlert(message, type = 'success') {
  alert.value.show = true
  alert.value.message = message
  alert.value.color = type === 'success' ? 'bg-green-500' : 'bg-red-500'
  setTimeout(() => (alert.value.show = false), 3000)
}

function openForm(event = null) {
  isEdit.value = !!event
  form.value = event ? { ...event } : { id: null, title: '', date: '', desc: '' }
  showForm.value = true
}

function closeForm() {
  showForm.value = false
}

function submitForm() {
  loading.value = true
  setTimeout(() => {
    if (isEdit.value) {
      const idx = events.value.findIndex(e => e.id === form.value.id)
      if (idx !== -1) events.value[idx] = { ...form.value }
      showAlert('✅ Data berhasil diperbarui', 'success')
    } else {
      const id = events.value.length ? Math.max(...events.value.map(e => e.id)) + 1 : 1
      events.value.push({ ...form.value, id })
      showAlert('🎉 Event baru berhasil ditambahkan', 'success')
    }
    loading.value = false
    showForm.value = false
  }, 500)
}

function deleteEvent(id) {
  if (confirm('Yakin ingin menghapus event ini?')) {
    events.value = events.value.filter(e => e.id !== id)
    showAlert('🗑️ Event berhasil dihapus', 'error')
  }
}
</script>

<style>
.font-cursive {
  font-family: 'Indie Flower', cursive;
}

.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.4s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
</style>
