<template>
  <div class="max-w-3xl mx-auto mt-6 mb-10 p-6 glass-card py-16">
    <h2 class="text-5xl font-light text-blue-700 mb-6 text-center">
      Form Aspirasi Siswa
    </h2>

    <form @submit.prevent="submitForm" class="space-y-5">
      <!-- Nama -->
      <div>
        <label class="block mb-1 font-light">Nama Lengkap</label>
        <input
          v-model="form.nama"
          type="text"
          placeholder="Masukkan nama lengkap"
          class="input"
          required
        />
      </div>

      <!-- NIS -->
      <div>
        <label class="block mb-1 font-light">NIS</label>
        <input
          v-model="form.nis"
          type="text"
          placeholder="Masukkan NIS"
          class="input"
          required
        />
      </div>

      <!-- Kelas -->
      <div>
        <label class="block mb-1 font-light">Kelas</label>
        <select v-model="form.kelas" class="input" required>
          <option value="" disabled>Pilih kelas</option>
          <option value="10">Kelas 10</option>
          <option value="11">Kelas 11</option>
          <option value="12">Kelas 12</option>
        </select>
      </div>

      <!-- Aspirasi -->
      <div>
        <label class="block mb-1 font-light">Aspirasi / Keluhan</label>
        <textarea
          v-model="form.aspirasi"
          rows="5"
          placeholder="Tulis aspirasi atau keluhanmu dengan jelas..."
          class="input"
          required
        ></textarea>
      </div>

      <!-- Submit -->
      <button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-200"
      >
        Kirim Aspirasi
      </button>
    </form>
    <br/>
    <router-link to="/" class="text-blue-600 hover:underline mb-8 inline-block font-light">&larr; Kembali ke Beranda</router-link>

    <!-- Notifikasi -->
    <p v-if="submitted" class="text-green-600 mt-4 text-center font-light">
      Terima kasih! Aspirasi kamu sudah terkirim 🙌
    </p>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";

const submitted = ref(false);
const form = reactive({
  nama: "",
  nis: "",
  kelas: "",
  aspirasi: "",
});

function submitForm() {
  console.log("Aspirasi terkirim:", form); // sementara, nanti bisa diarahkan ke API
  submitted.value = true;

  // reset form
  form.nama = "";
  form.nis = "";
  form.kelas = "";
  form.aspirasi = "";
}
</script>

<style scoped>
.input {
  @apply w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none bg-white/60 backdrop-blur;
}
.glass-card {
  background: rgba(255, 255, 255, 0.55);
  backdrop-filter: blur(18px);
  border-radius: 20px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}
</style>
