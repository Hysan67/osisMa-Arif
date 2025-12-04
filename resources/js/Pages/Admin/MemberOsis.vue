<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-blue-700">Member OSIS</h2>
      <button @click="openForm" class="bg-white text-blue-700 px-3 py-2 rounded shadow hover:bg-gray-100">
        + Tambah Member
      </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <thead class="bg-blue-700 text-white">
          <tr>
            <th class="py-3 px-4 text-left">Nama</th>
            <th class="py-3 px-4 text-left">Jabatan</th>
            <th class="py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(m, index) in members" :key="index" class="border-b">
            <td class="py-3 px-4">{{ m.nama }}</td>
            <td class="py-3 px-4">{{ m.jabatan }}</td>
            <td class="py-3 px-4 flex justify-center gap-3">
              <button @click="editMember(index)" class="text-yellow-500 hover:text-yellow-600">✏️</button>
              <button @click="hapusMember(index)" class="text-red-600 hover:text-red-700">🗑️</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal Form -->
    <div v-if="showForm" class="fixed inset-0 bg-black/50 flex justify-center items-center">
      <div class="bg-white rounded p-6 w-full max-w-lg">
        <h3 class="text-xl font-semibold mb-4">
          {{ editingIndex === null ? "Tambah Member" : "Edit Member" }}
        </h3>

        <input v-model="form.nama" type="text" placeholder="Nama member"
          class="w-full mb-3 px-3 py-2 border rounded" />
        <input v-model="form.jabatan" type="text" placeholder="Jabatan"
          class="w-full mb-4 px-3 py-2 border rounded" />

        <div class="flex justify-end gap-3">
          <button @click="showForm = false" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
          <button @click="simpanMember" class="px-4 py-2 bg-blue-700 text-white rounded">
            Simpan
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue"

const members = ref([
  { nama: "Budi Saputra", jabatan: "Ketua OSIS" },
  { nama: "Sita Ramadhani", jabatan: "Sekretaris" }
])

const showForm = ref(false)
const editingIndex = ref(null)
const form = ref({ nama: "", jabatan: "" })

const openForm = () => {
  editingIndex.value = null
  form.value = { nama: "", jabatan: "" }
  showForm.value = true
}

const editMember = (index) => {
  editingIndex.value = index
  form.value = { ...members.value[index] }
  showForm.value = true
}

const simpanMember = () => {
  if (editingIndex.value === null) {
    members.value.push(form.value)
  } else {
    members.value[editingIndex.value] = form.value
  }
  showForm.value = false
}

const hapusMember = (index) => {
  if (confirm("Yakin hapus member?")) members.value.splice(index, 1)
}
</script>
