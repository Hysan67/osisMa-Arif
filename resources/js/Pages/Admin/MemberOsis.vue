<template>
  <div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-2xl font-semibold text-blue-700">Member OSIS</h2>
        <p class="text-gray-600 text-sm mt-1">Kelola data anggota OSIS per bidang dan status</p>
      </div>
      <button 
        @click="openForm()" 
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition"
      >
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Anggota
      </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
          <div class="p-2 rounded-full bg-blue-100 text-blue-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Total Anggota</p>
            <p class="text-2xl font-semibold text-gray-900">{{ anggotas.length }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
          <div class="p-2 rounded-full bg-green-100 text-green-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Aktif</p>
            <p class="text-2xl font-semibold text-gray-900">{{ getCountByStatus('aktif') }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
          <div class="p-2 rounded-full bg-gray-100 text-gray-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Non Aktif</p>
            <p class="text-2xl font-semibold text-gray-900">{{ getCountByStatus('non aktif') }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
          <div class="p-2 rounded-full bg-purple-100 text-purple-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Total Bidang</p>
            <p class="text-2xl font-semibold text-gray-900">{{ bidangs.length }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Controls -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
      <div class="mb-4">
        <h3 class="text-sm font-medium text-gray-700 mb-3">Filter Anggota</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <!-- Filter by Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select 
              v-model="filters.status" 
              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Semua Status</option>
              <option value="aktif">Aktif</option>
              <option value="non aktif">Non Aktif</option>
            </select>
          </div>

          <!-- Filter by Bidang -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bidang</label>
            <select 
              v-model="filters.bidang_id" 
              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Semua Bidang</option>
              <option v-for="bidang in bidangs" :key="bidang.id" :value="bidang.id">
                {{ bidang.nama }}
              </option>
            </select>
          </div>

          <!-- Filter by Posisi/Jabatan -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
            <select 
              v-model="filters.posisi" 
              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Semua Posisi</option>
              <option v-for="posisi in posisiOptions" :key="posisi" :value="posisi">
                {{ posisi }}
              </option>
            </select>
          </div>

          <!-- Search -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
            <div class="relative">
              <input
                v-model="filters.search"
                type="text"
                placeholder="Cari anggota..."
                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
              <div class="absolute left-3 top-2.5">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Active Filters -->
      <div v-if="hasActiveFilters" class="mt-4 flex flex-wrap gap-2">
        <span class="text-sm text-gray-600">Filter aktif:</span>
        <span 
          v-if="filters.status" 
          class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800"
        >
          Status: {{ filters.status === 'aktif' ? 'Aktif' : 'Non Aktif' }}
          <button @click="filters.status = ''" class="ml-1 text-green-600 hover:text-green-800">
            &times;
          </button>
        </span>
        <span 
          v-if="filters.bidang_id" 
          class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800"
        >
          Bidang: {{ getBidangName(filters.bidang_id) }}
          <button @click="filters.bidang_id = ''" class="ml-1 text-blue-600 hover:text-blue-800">
            &times;
          </button>
        </span>
        <span 
          v-if="filters.posisi" 
          class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800"
        >
          Posisi: {{ filters.posisi }}
          <button @click="filters.posisi = ''" class="ml-1 text-purple-600 hover:text-purple-800">
            &times;
          </button>
        </span>
        <button 
          @click="resetFilters"
          class="text-sm text-red-600 hover:text-red-800"
        >
          Reset semua filter
        </button>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading && anggotas.length === 0" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
      <p class="mt-4 text-gray-600">Memuat data anggota...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error && anggotas.length === 0" class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
      <div class="text-red-600 mb-2">
        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <h3 class="text-lg font-medium text-red-800 mb-2">Gagal memuat data</h3>
      <p class="text-red-700 mb-4">{{ error }}</p>
      <button
        @click="fetchData"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg"
      >
        Coba Lagi
      </button>
    </div>

    <!-- Empty State -->
    <div v-else-if="filteredAnggota.length === 0" class="bg-white rounded-lg shadow p-8 text-center">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
      </svg>
      <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada anggota</h3>
      <p class="text-gray-600 mb-6">Mulai dengan menambahkan anggota pertama Anda</p>
      <button
        @click="openForm()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
      >
        Tambah Anggota Pertama
      </button>
    </div>

    <!-- Display Mode Toggle -->
    <div v-else class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-gray-800">
        Daftar Anggota 
        <span class="text-sm font-normal text-gray-600">
          ({{ filteredAnggota.length }} dari {{ anggotas.length }})
        </span>
      </h3>
      <div class="flex space-x-2">
        <button
          @click="displayMode = 'grid'"
          :class="displayMode === 'grid' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
          class="p-2 rounded-lg"
          title="Grid View"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
          </svg>
        </button>
        <button
          @click="displayMode = 'table'"
          :class="displayMode === 'table' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
          class="p-2 rounded-lg"
          title="Table View"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Grid View -->
    <div v-if="displayMode === 'grid' && filteredAnggota.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <div
        v-for="anggota in filteredAnggota"
        :key="anggota.id"
        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition"
      >
        <!-- Header with Image -->
        <div class="relative h-48 overflow-hidden">
          <img
            :src="getImageUrl(anggota.img)"
            :alt="anggota.nama"
            class="w-full h-full object-cover"
          />
          <!-- Status Badge -->
          <div class="absolute top-3 right-3">
            <span 
              :class="anggota.status === 'aktif' ? 'bg-green-500' : 'bg-gray-500'"
              class="text-white text-xs px-2 py-1 rounded-full"
            >
              {{ anggota.status === 'aktif' ? 'Aktif' : 'Non Aktif' }}
            </span>
          </div>
          <!-- Bidang Badge -->
          <div class="absolute bottom-3 left-3">
            <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded">
              {{ getBidangName(anggota.bidang_id) || 'Umum' }}
            </span>
          </div>
        </div>
        
        <!-- Content -->
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ anggota.nama }}</h3>
          <p class="text-blue-600 font-medium text-sm mb-2">{{ anggota.posisi }}</p>
          
          <!-- Quote -->
          <div class="mb-3">
            <p class="text-gray-600 text-sm italic">"{{ truncateText(anggota.quote, 80) }}"</p>
          </div>
          
          <!-- Masa Bakti -->
          <div class="mb-4">
            <p class="text-xs text-gray-500">Masa Bakti:</p>
            <p class="text-sm font-medium text-gray-800">{{ anggota.masa_bakti }}</p>
          </div>
          
          <!-- Actions -->
          <div class="flex justify-between pt-3 border-t border-gray-100">
            <button
              @click="viewDetail(anggota)"
              class="text-blue-600 hover:text-blue-800 text-sm font-medium"
            >
              Detail
            </button>
            <div class="flex space-x-2">
              <button
                @click="editAnggota(anggota)"
                class="text-green-600 hover:text-green-800 p-1"
                title="Edit"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
              </button>
              <!-- Ganti tombol hapus menjadi nonaktifkan -->
              <button
                @click="confirmToggleStatus(anggota)"
                class="text-yellow-600 hover:text-yellow-800 p-1"
                title="Nonaktifkan"
              >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Table View -->
    <div v-else-if="displayMode === 'table' && filteredAnggota.length > 0" class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bidang</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masa Bakti</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="anggota in filteredAnggota" :key="anggota.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex-shrink-0 h-10 w-10">
                  <img
                    :src="getImageUrl(anggota.img)"
                    :alt="anggota.nama"
                    class="h-10 w-10 rounded-full object-cover"
                  />
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ anggota.nama }}</div>
                <div class="text-sm text-gray-500 truncate max-w-xs">"{{ truncateText(anggota.quote, 60) }}"</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ anggota.posisi }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                  {{ getBidangName(anggota.bidang_id) || 'Umum' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span 
                  :class="anggota.status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                >
                  {{ anggota.status === 'aktif' ? 'Aktif' : 'Non Aktif' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ anggota.masa_bakti }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-3">
                  <button
                    @click="viewDetail(anggota)"
                    class="text-blue-600 hover:text-blue-900"
                    title="Detail"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                  </button>
                  <button
                    @click="editAnggota(anggota)"
                    class="text-green-600 hover:text-green-900"
                    title="Edit"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                  </button>
                  <!-- Ganti tombol hapus menjadi nonaktifkan -->
                  <button
                    @click="confirmToggleStatus(anggota)"
                    class="text-yellow-600 hover:text-yellow-900"
                    title="Nonaktifkan"
                  >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modals -->
    <AnggotaModal 
    v-if="showForm"
    :show="showForm"
    :is-edit="isEdit"
    :form-data="form"
    :bidangs="bidangs"
    @save="saveAnggota"
    @close="closeForm"
  />

    <DetailAnggota
      v-if="showDetailModal"
      :anggota="detailAnggota"
      :bidang="getBidang(detailAnggota?.bidang_id)"
      :show="showDetailModal"
      @close="closeDetailModal"
      @edit="editAnggota(detailAnggota)"
    />

    <!-- Ganti modal konfirmasi hapus menjadi konfirmasi ubah status -->
    <ConfirmationModal
      v-if="showStatusModal"
      :show="showStatusModal"
      @close="showStatusModal = false"
      @confirmed="toggleStatus"
    >
      <template #title>
        {{ statusToChange === 'aktif' ? 'Aktifkan' : 'Nonaktifkan' }} Anggota
      </template>
      <template #content>
        <p class="text-gray-700">Apakah Anda yakin ingin {{ statusToChange === 'aktif' ? 'mengaktifkan' : 'menonaktifkan' }} anggota <strong>{{ anggotaToToggle?.nama }}</strong>?</p>
        <p class="mt-2 text-sm text-gray-600">Anggota akan tetap tersimpan dalam sistem.</p>
      </template>
    </ConfirmationModal>

    <!-- Alert -->
    <transition name="fade-slide">
      <div v-if="alert.show" class="fixed bottom-6 right-6 px-4 py-3 rounded-lg shadow-lg text-white z-50" :class="alert.color">
        {{ alert.message }}
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import axios from "axios";

import AnggotaModal from '@/Components/Modals/AnggotaModal.vue';
import DetailAnggota from '@/Components/Modals/DetailAnggota.vue';
import ConfirmationModal from '@/Components/Modals/ConfirmationModal.vue';

// State
const anggotas = ref([]);
const bidangs = ref([]);
const loading = ref(false);
const error = ref("");
const displayMode = ref("grid");

// Modal states - Ganti showDeleteModal menjadi showStatusModal
const showForm = ref(false);
const showDetailModal = ref(false);
const showStatusModal = ref(false); // Ganti nama variabel
const isEdit = ref(false);

// Data for modals
const detailAnggota = ref(null);
// Ganti anggotaToDelete menjadi anggotaToToggle dan tambahkan statusToChange
const anggotaToToggle = ref(null);
const statusToChange = ref('non aktif'); // 'aktif' atau 'non aktif'

// Form data
const form = ref({
  id: null,
  nama: "",
  posisi: "",
  bidang_id: "",
  status: "aktif",
  masa_bakti: "",
  quote: "",
  pengalaman_prestasi: "",
  img: null,
  imgPreview: null,
});

// Filters
const filters = reactive({
  status: "",
  bidang_id: "",
  posisi: "",
  search: ""
});

// Alert
const alert = ref({ show: false, message: "", color: "bg-green-500" });

// Constants
const posisiOptions = [
  'Ketua Umum',
  'Ketua',
  'Sekretaris Umum',
  'Sekretaris',
  'Bendahara Umum',
  'Bendahara',
  'Ketua Departemen',
  'Anggota'
];

// Computed Properties
const hasActiveFilters = computed(() => {
  return filters.status || filters.bidang_id || filters.posisi || filters.search;
});

const filteredAnggota = computed(() => {
  return anggotas.value.filter(anggota => {
    if (filters.status && anggota.status !== filters.status) return false;
    if (filters.bidang_id && anggota.bidang_id != filters.bidang_id) return false;
    if (filters.posisi && anggota.posisi !== filters.posisi) return false;
    
    if (filters.search) {
      const searchLower = filters.search.toLowerCase();
      return (
        anggota.nama.toLowerCase().includes(searchLower) ||
        anggota.posisi.toLowerCase().includes(searchLower) ||
        (anggota.quote && anggota.quote.toLowerCase().includes(searchLower)) ||
        (anggota.pengalaman_prestasi && anggota.pengalaman_prestasi.toLowerCase().includes(searchLower))
      );
    }
    
    return true;
  });
});

// Methods
function showAlert(msg, type = "success") {
  alert.value = { show: true, message: msg, color: type === "success" ? "bg-green-500" : "bg-red-500" };
  setTimeout(() => (alert.value.show = false), 3000);
}

function getImageUrl(imgPath) {
  if (!imgPath) return 'https://via.placeholder.com/400x300?text=No+Image  ';
  if (imgPath.startsWith('http')) return imgPath;
  if (imgPath.startsWith('public/')) imgPath = imgPath.replace('public/', '');
  if (imgPath.startsWith('/')) imgPath = imgPath.substring(1);
  return `/storage/${imgPath}`;
}

function handleFileUpload(e) {
  const file = e.target.files[0];
  if (file) {
    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!validTypes.includes(file.type)) {
      showAlert('Format file harus JPG, PNG, atau GIF', 'error');
      return;
    }
    
    form.value.img = file;
    const reader = new FileReader();
    reader.onload = (e) => form.value.imgPreview = e.target.result;
    reader.readAsDataURL(file);
  }
}

function getCountByStatus(status) {
  return anggotas.value.filter(a => a.status === status).length;
}

function getBidangName(bidangId) {
  const bidang = bidangs.value.find(b => b.id == bidangId);
  return bidang ? bidang.nama : '';
}

function getBidang(bidangId) {
  return bidangs.value.find(b => b.id == bidangId);
}

function resetFilters() {
  filters.status = '';
  filters.bidang_id = '';
  filters.posisi = '';
  filters.search = '';
}

function truncateText(text, length) {
  if (!text) return '';
  return text.length > length ? text.substring(0, length) + '...' : text;
}

// Form Methods
function openForm(data = null) {
  isEdit.value = !!data;
  if (data) {
    form.value = {
      id: data.id,
      nama: data.nama,
      posisi: data.posisi,
      bidang_id: data.bidang_id || "",
      status: data.status || "aktif",
      masa_bakti: data.masa_bakti,
      quote: data.quote || "",
      pengalaman_prestasi: data.pengalaman_prestasi || "",
      img: null,
      imgPreview: data.img ? getImageUrl(data.img) : null,
    };
  } else {
    form.value = {
      id: null,
      nama: "",
      posisi: "",
      bidang_id: "",
      status: "aktif",
      masa_bakti: "",
      quote: "",
      pengalaman_prestasi: "",
      img: null,
      imgPreview: null,
    };
  }
  showForm.value = true;
}

function closeForm() {
  showForm.value = false;
  form.value.imgPreview = null;
}

function editAnggota(anggota) {
  isEdit.value = true;
  form.value = {
    id: anggota.id,
    nama: anggota.nama || "",
    posisi: anggota.posisi || "",
    bidang_id: anggota.bidang_id || "",
    status: anggota.status || "aktif",
    masa_bakti: anggota.masa_bakti || "",
    quote: anggota.quote || "",
    pengalaman_prestasi: anggota.pengalaman_prestasi || "",
    img: null,
    imgPreview: anggota.img ? getImageUrl(anggota.img) : null,
  };
  showForm.value = true;
  showDetailModal.value = false;
}

function viewDetail(anggota) {
  detailAnggota.value = {
    ...anggota,
    img: anggota.img,
    nama: anggota.nama,
    posisi: anggota.posisi,
    quote: anggota.quote || "",
    pengalaman_prestasi: anggota.pengalaman_prestasi || "-",
    masa_bakti: anggota.masa_bakti,
    status: anggota.status,
    bidang_id: anggota.bidang_id,
    created_at: anggota.created_at,
    updated_at: anggota.updated_at
  };
  showDetailModal.value = true;
}

function closeDetailModal() {
  showDetailModal.value = false;
  detailAnggota.value = null;
}

// Ganti confirmDelete menjadi confirmToggleStatus
function confirmToggleStatus(anggota) {
  anggotaToToggle.value = anggota;
  // Tentukan status tujuan: jika aktif -> non aktif, jika non aktif -> aktif
  statusToChange.value = anggota.status === 'aktif' ? 'non aktif' : 'aktif';
  showStatusModal.value = true; // Ganti ke showStatusModal
}

// Ganti deleteAnggota menjadi toggleStatus
async function toggleStatus() {
  if (!anggotaToToggle.value) return;
  
  try {
    const token = localStorage.getItem('token');
    await axios.put(`/anggota/${anggotaToToggle.value.id}/status`, {
      status: statusToChange.value
    }, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });

    const action = statusToChange.value === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
    showAlert(`Anggota berhasil ${action}`, "success");
    showStatusModal.value = false; // Ganti ke showStatusModal
    anggotaToToggle.value = null;
    await fetchData(); // Refresh data
  } catch (err) {
    console.error(err);
    const action = statusToChange.value === 'aktif' ? 'mengaktifkan' : 'menonaktifkan';
    showAlert(`Gagal ${action} anggota: ` + (err.response?.data?.message || "Error"), "error");
  }
}


// API Functions
async function fetchData() {
  loading.value = true;
  error.value = "";
  
  try {
    // Fetch anggotas
    const anggotaResponse = await axios.get('/anggota', {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`,
        'Accept': 'application/json'
      }
    });
    anggotas.value = anggotaResponse.data.data || anggotaResponse.data;
    
    // Fetch bidangs
    const bidangResponse = await axios.get('/bidang', {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`,
        'Accept': 'application/json'
      }
    });
    bidangs.value = bidangResponse.data.data || bidangResponse.data;
  } catch (err) {
    console.error('Error fetching data:', err);
    error.value = 'Gagal memuat data. Silakan coba lagi.';
    showAlert("Gagal memuat data: " + (err.response?.data?.message || "Error"), "error");
  } finally {
    loading.value = false;
  }
}

async function saveAnggota(formData) {
  try {
    const token = localStorage.getItem('token');
    
    if (isEdit.value) {
      formData.append('_method', 'PUT');
      await axios.post(`/anggota/${form.value.id}`, formData, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'multipart/form-data'
        }
      });
      showAlert("Anggota berhasil diperbarui");
    } else {
      await axios.post('/anggota', formData, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'multipart/form-data'
        }
      });
      showAlert("Anggota baru berhasil ditambahkan");
    }
    
    closeForm();
    await fetchData();
  } catch (err) {
    console.error("Error detail:", err);
    let errorMessage = "Gagal menyimpan anggota";
    if (err.response?.data?.message) {
      errorMessage = err.response.data.message;
    } else if (err.response?.data?.errors) {
      errorMessage = Object.values(err.response.data.errors).flat().join(', ');
    }
    showAlert(errorMessage, "error");
  }
}

// Ganti komentar dan hapus fungsi deleteAnggota lama
// async function deleteAnggota() {
//   if (!anggotaToDelete.value) return;
//   try {
//     await axios.delete(`/anggota/${anggotaToDelete.value.id}`, {
//       headers: {
//         'Authorization': `Bearer ${localStorage.getItem('token')}`,
//         'Accept': 'application/json'
//       }
//     });
//     showAlert("Anggota berhasil dihapus", "success");
//     showDeleteModal.value = false;
//     anggotaToDelete.value = null;
//     await fetchData();
//   } catch (err) {
//     console.error(err);
//     showAlert("Gagal menghapus anggota: " + (err.response?.data?.message || "Error"), "error");
//   }
// }

// Lifecycle
onMounted(() => {
  fetchData();
});
</script>

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
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