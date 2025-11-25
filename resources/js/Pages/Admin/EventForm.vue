<!-- src/pages/Admin/EventForm.vue -->
<template>
  <div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">{{ isEdit ? 'Edit Event' : 'Tambah Event Baru' }}</h1>

    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label class="block text-gray-700">Judul Event</label>
        <input
          v-model="form.title"
          type="text"
          class="w-full p-2 border rounded"
          required
        />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Tanggal</label>
        <input
          v-model="form.date"
          type="date"
          class="w-full p-2 border rounded"
          required
        />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Deskripsi</label>
        <textarea
          v-model="form.desc"
          rows="4"
          class="w-full p-2 border rounded"
          required
        ></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Gambar (URL)</label>
        <input
          v-model="form.image"
          type="text"
          class="w-full p-2 border rounded"
        />
      </div>

      <button
        type="submit"
        class="px-4 py-2 bg-osisBlue text-white rounded hover:bg-blue-700"
        :disabled="loading"
      >
        {{ loading ? 'Menyimpan...' : 'Simpan' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useEventStore } from '@/store/useEventStore'
import api from '@/services/api'

const route = useRoute()
const router = useRouter()
const eventStore = useEventStore()

const isEdit = !!route.params.id
const loading = ref(false)

const form = ref({
  title: '',
  date: '',
  desc: '',
  image: ''
})

onMounted(() => {
  if (isEdit) {
    const event = eventStore.events.find(e => e.id === parseInt(route.params.id))
    if (event) {
      form.value = { ...event }
    } else {
      // Ambil dari API jika tidak ada di store
      fetchEvent()
    }
  }
})

const fetchEvent = async () => {
  try {
    const response = await api.get(`/events/${route.params.id}`)
    form.value = response.data
  } catch (error) {
    console.error('Gagal mengambil data event:', error)
  }
}

const submitForm = async () => {
  loading.value = true
  try {
    if (isEdit) {
      await api.put(`/events/${route.params.id}`, form.value)
    } else {
      await api.post('/events', form.value)
    }
    eventStore.fetchEvents() // Refresh data
    router.push('/admin')
  } catch (error) {
    console.error('Gagal menyimpan event:', error)
  } finally {
    loading.value = false
  }
}
</script>