<template>
  <div>
    <!-- Judul -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-[#1E40AF]">Daftar Event</h2>

      <button
        @click="openForm()"
        class="bg-[#1E40AF] hover:bg-[#1E3A8A] text-white px-4 py-2 rounded"
      >
        + Tambah Event Baru
      </button>
    </div>

    <!-- Tabel Event -->
    <table class="w-full border border-gray-300 rounded bg-white overflow-hidden">
      <thead class="bg-blue-700 text-white">
        <tr>
          <th class="py-2 px-4 border-b border-gray-300 text-left">Nama Event</th>
          <th class="py-2 px-4 border-b border-gray-300 text-center w-40">Aksi</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="event in events"
          :key="event.id"
          class="odd:bg-gray-50 even:bg-white"
        >
          <td class="py-2 px-4 border-b border-gray-300">
            {{ event.title }}
          </td>

          <td class="py-2 px-4 border-b border-gray-300 text-center space-x-3">
            <button @click="editMember(index)" class="text-yellow-500 hover:text-yellow-600">✏️</button>
              <button @click="hapusMember(index)" class="text-red-600 hover:text-red-700">🗑️</button>
          </td>
        </tr>

        <!-- Jika kosong -->
        <tr v-if="events.length === 0">
          <td colspan="2" class="py-4 text-center text-gray-500">
            Belum ada event.
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal Tambah/Edit Event -->
    <div
      v-if="showForm"
      class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50"
    >
      <div class="bg-white rounded-md shadow-lg max-w-lg w-full p-6">
        <h3 class="text-xl font-semibold mb-4">
          {{ isEdit ? "Edit Event" : "Tambah Event Baru" }}
        </h3>

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
              {{ isEdit ? "Update" : "Simpan" }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ALERT -->
    <transition name="fade-slide">
      <div
        v-if="alert.show"
        class="fixed bottom-6 right-6 px-4 py-3 rounded-lg shadow-lg text-white font-medium z-[9999]"
        :class="alert.color"
      >
        {{ alert.message }}
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref } from "vue"

const events = ref([
  { id: 1, title: "Event 1", date: "2024-01-10", desc: "Deskripsi event 1" },
  { id: 2, title: "Event 2", date: "2024-02-15", desc: "Deskripsi event 2" },
])

const showForm = ref(false)
const isEdit = ref(false)
const form = ref({ id: null, title: "", date: "", desc: "" })

// ALERT
const alert = ref({
  show: false,
  message: "",
  color: "bg-green-500",
})

function showAlert(msg, type = "success") {
  alert.value.message = msg
  alert.value.color = type === "success" ? "bg-green-500" : "bg-red-500"
  alert.value.show = true

  setTimeout(() => (alert.value.show = false), 2500)
}

function openForm(event = null) {
  isEdit.value = !!event
  form.value = event ? { ...event } : { id: null, title: "", date: "", desc: "" }
  showForm.value = true
}

function closeForm() {
  showForm.value = false
}

function submitForm() {
  if (isEdit.value) {
    const index = events.value.findIndex(e => e.id === form.value.id)
    if (index !== -1) events.value[index] = { ...form.value }
    showAlert("Event berhasil diperbarui!", "success")
  } else {
    const id =
      events.value.length > 0
        ? Math.max(...events.value.map(e => e.id)) + 1
        : 1
    events.value.push({ ...form.value, id })
    showAlert("Event berhasil ditambahkan!", "success")
  }

  showForm.value = false
}

function deleteEvent(id) {
  if (confirm("Yakin ingin menghapus event ini?")) {
    events.value = events.value.filter(e => e.id !== id)
    showAlert("Event berhasil dihapus!", "error")
  }
}
</script>

<style>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(15px);
}
</style>
