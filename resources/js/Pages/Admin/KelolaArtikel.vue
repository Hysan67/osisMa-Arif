<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-blue-700">Kelola Artikel</h2>
      <button @click="openForm" class="bg-white text-blue-700 px-3 py-2 rounded shadow hover:bg-gray-100">
        + Tambah Artikel
      </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <thead class="bg-blue-700 text-white">
          <tr>
            <th class="py-3 px-4 text-left">Judul</th>
            <th class="py-3 px-4 text-left">Tanggal</th>
            <th class="py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(artikel, index) in articles" :key="index" class="border-b">
            <td class="py-3 px-4">{{ artikel.judul }}</td>
            <td class="py-3 px-4">{{ artikel.tanggal }}</td>
            <td class="py-3 px-4 flex justify-center gap-3">
              <button @click="editArtikel(index)" class="text-yellow-500 hover:text-yellow-600">✏️</button>
              <button @click="hapusArtikel(index)" class="text-red-600 hover:text-red-700">🗑️</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal Form -->
    <div v-if="showForm" class="fixed inset-0 bg-black/50 flex justify-center items-center">
      <div class="bg-white rounded p-6 w-full max-w-lg">
        <h3 class="text-xl font-semibold mb-4">
          {{ editingIndex === null ? "Tambah Artikel" : "Edit Artikel" }}
        </h3>

        <input v-model="form.judul" type="text" placeholder="Judul artikel"
          class="w-full mb-3 px-3 py-2 border rounded" />
        <textarea v-model="form.isi" rows="5" placeholder="Isi artikel"
          class="w-full mb-3 px-3 py-2 border rounded"></textarea>
        
        <div class="flex justify-end gap-3">
          <button @click="showForm = false" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
          <button @click="simpanArtikel" class="px-4 py-2 bg-blue-700 text-white rounded">
            Simpan
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue"

const articles = ref([
  { judul: "Kegiatan Upacara Hari Senin", tanggal: "2025-01-11", isi: "Lorem ipsum..." },
  { judul: "Rapat Besar OSIS 2025", tanggal: "2025-01-18", isi: "Lorem ipsum..." }
])

const showForm = ref(false)
const editingIndex = ref(null)
const form = ref({ judul: "", isi: "" })

const openForm = () => {
  editingIndex.value = null
  form.value = { judul: "", isi: "" }
  showForm.value = true
}

const editArtikel = (index) => {
  editingIndex.value = index
  form.value = { ...articles.value[index] }
  showForm.value = true
}

const simpanArtikel = () => {
  if (editingIndex.value === null) {
    articles.value.push({
      ...form.value,
      tanggal: new Date().toISOString().split("T")[0]
    })
  } else {
    articles.value[editingIndex.value] = {
      ...form.value,
      tanggal: articles.value[editingIndex.value].tanggal
    }
  }
  showForm.value = false
}

const hapusArtikel = (index) => {
  if (confirm("Yakin hapus artikel?")) articles.value.splice(index, 1)
}
</script>
