<template>
  <div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-2xl font-semibold text-blue-700">Member OSIS</h2>
        <p class="text-gray-600 text-sm mt-1">Kelola data anggota OSIS per bidang dan status</p>
      </div>
      <button 
        @click="openForm('add')" 
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
            <p class="text-2xl font-semibold text-gray-900">{{ anggotaStore.anggotas.length }}</p>
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
            <p class="text-2xl font-semibold text-gray-900">{{ bidangStore.bidangs.length }}</p>
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
              <option v-for="bidang in bidangStore.bidangs" :key="bidang.id" :value="bidang.id">
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
    <div v-if="anggotaStore.loading && anggotaStore.anggotas.length === 0" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
      <p class="mt-4 text-gray-600">Memuat data anggota...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="anggotaStore.error && anggotaStore.anggotas.length === 0" class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
      <div class="text-red-600 mb-2">
        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <h3 class="text-lg font-medium text-red-800 mb-2">Gagal memuat data</h3>
      <p class="text-red-700 mb-4">{{ anggotaStore.error }}</p>
      <button
        @click="fetchAnggota"
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
        @click="openForm('add')"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
      >
        Tambah Anggota Pertama
      </button>
    </div>

    <!-- Display Mode Toggle -->
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-gray-800">
        Daftar Anggota 
        <span class="text-sm font-normal text-gray-600">
          ({{ filteredAnggota.length }} dari {{ anggotaStore.anggotas.length }})
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
    <div v-if="displayMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
            @error="handleImageError"
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
              <button
                @click="confirmDelete(anggota)"
                class="text-red-600 hover:text-red-800 p-1"
                title="Hapus"
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
    <div v-else class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bidang</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masa Bakti</th>
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
                    @error="handleImageError"
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
                  <button
                    @click="confirmDelete(anggota)"
                    class="text-red-600 hover:text-red-900"
                    title="Hapus"
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

    <!-- Modal Form -->
    <AnggotaModal
      v-if="showModal"
      :show="showModal"
      :mode="modalMode"
      :anggota="selectedAnggota"
      :bidangs="bidangStore.bidangs"
      @close="closeModal"
      @saved="handleSaved"
    />

    <!-- Delete Confirmation Modal -->
    <ConfirmationModal
      :show="showDeleteModal"
      @close="showDeleteModal = false"
      @confirmed="handleDelete"
    >
      <template #title>
        Hapus Anggota
      </template>
      <template #content>
        <p class="text-gray-700">Apakah Anda yakin ingin menghapus anggota <strong>{{ anggotaToDelete?.nama }}</strong>?</p>
        <p class="mt-2 text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan.</p>
      </template>
    </ConfirmationModal>

    <!-- Detail Modal -->
    <AnggotaDetailModal
      v-if="showDetailModal"
      :anggota="detailAnggota"
      :bidang="getBidang(detailAnggota?.bidang_id)"
      @close="showDetailModal = false"
      @edit="editAnggota(detailAnggota)"
    />
  </div>
</template>

<script>
import { ref, reactive, computed, onMounted, watch } from 'vue'
import AnggotaModal from '@/Components/Modals/AnggotaModal.vue'
import AnggotaDetailModal from '@/Components/Modals/AnggotaDetailModal.vue'
import ConfirmationModal from '@/Components/Modals/ConfirmationModal.vue'

export default {
  name: 'MemberOsis',
  
  components: {
    AnggotaModal,
    AnggotaDetailModal,
    ConfirmationModal
  },
  
  setup() {
    // Store data (simulated - in real app, use Pinia/Vuex)
    const anggotaStore = reactive({
      anggotas: [],
      loading: false,
      error: null
    })

    const bidangStore = reactive({
      bidangs: []
    })

    // Display mode
    const displayMode = ref('grid')
    
    // Modal state
    const showModal = ref(false)
    const modalMode = ref('add')
    const selectedAnggota = ref(null)
    
    // Detail modal
    const showDetailModal = ref(false)
    const detailAnggota = ref(null)
    
    // Delete confirmation
    const showDeleteModal = ref(false)
    const anggotaToDelete = ref(null)
    
    // Filters
    const filters = reactive({
      status: '',
      bidang_id: '',
      posisi: '',
      search: ''
    })

    // Posisi options
    const posisiOptions = [
      'Ketua OSIS',
      'Wakil Ketua OSIS',
      'Sekretaris',
      'Bendahara',
      'Ketua Bidang',
      'Anggota'
    ]

    // Computed
    const hasActiveFilters = computed(() => {
      return filters.status || filters.bidang_id || filters.posisi || filters.search
    })

    const filteredAnggota = computed(() => {
      return anggotaStore.anggotas.filter(anggota => {
        // Filter by status
        if (filters.status && anggota.status !== filters.status) return false
        
        // Filter by bidang
        if (filters.bidang_id && anggota.bidang_id != filters.bidang_id) return false
        
        // Filter by posisi
        if (filters.posisi && anggota.posisi !== filters.posisi) return false
        
        // Filter by search
        if (filters.search) {
          const searchLower = filters.search.toLowerCase()
          return (
            anggota.nama.toLowerCase().includes(searchLower) ||
            anggota.posisi.toLowerCase().includes(searchLower) ||
            anggota.quote.toLowerCase().includes(searchLower) ||
            anggota.pengalaman_prestasi.toLowerCase().includes(searchLower)
          )
        }
        
        return true
      })
    })

    // Methods
    const fetchAnggota = async () => {
      anggotaStore.loading = true
      try {
        const token = localStorage.getItem('token')
        const response = await fetch('/api/anggota', {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        })
        
        if (response.ok) {
          const data = await response.json()
          anggotaStore.anggotas = data.data || data
        }
      } catch (error) {
        anggotaStore.error = 'Gagal memuat data anggota'
        console.error('Error fetching anggota:', error)
      } finally {
        anggotaStore.loading = false
      }
    }

    const fetchBidangs = async () => {
      try {
        const token = localStorage.getItem('token')
        const response = await fetch('/api/bidang', {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        })
        
        if (response.ok) {
          const data = await response.json()
          bidangStore.bidangs = data.data || data
        }
      } catch (error) {
        console.error('Error fetching bidangs:', error)
      }
    }

    const getCountByStatus = (status) => {
      return anggotaStore.anggotas.filter(a => a.status === status).length
    }

    const getBidangName = (bidangId) => {
      const bidang = bidangStore.bidangs.find(b => b.id == bidangId)
      return bidang ? bidang.nama : ''
    }

    const getBidang = (bidangId) => {
      return bidangStore.bidangs.find(b => b.id == bidangId)
    }

    const resetFilters = () => {
      filters.status = ''
      filters.bidang_id = ''
      filters.posisi = ''
      filters.search = ''
    }

    const openForm = (mode, anggota = null) => {
      modalMode.value = mode
      selectedAnggota.value = anggota
      showModal.value = true
    }

    const closeModal = () => {
      showModal.value = false
      selectedAnggota.value = null
    }

    const handleSaved = () => {
      closeModal()
      fetchAnggota()
    }

    const editAnggota = (anggota) => {
      openForm('edit', anggota)
      showDetailModal.value = false
    }

    const viewDetail = (anggota) => {
      detailAnggota.value = anggota
      showDetailModal.value = true
    }

    const confirmDelete = (anggota) => {
      anggotaToDelete.value = anggota
      showDeleteModal.value = true
    }

    const handleDelete = async () => {
      if (!anggotaToDelete.value) return
      
      try {
        const token = localStorage.getItem('token')
        const response = await fetch(`/api/anggota/${anggotaToDelete.value.id}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        })
        
        if (response.ok) {
          await fetchAnggota()
          showDeleteModal.value = false
          anggotaToDelete.value = null
        }
      } catch (error) {
        console.error('Error deleting anggota:', error)
        alert('Gagal menghapus anggota')
      }
    }

    const getImageUrl = (imgPath) => {
      if (!imgPath) return 'https://via.placeholder.com/400x300?text=No+Image'
      if (imgPath.startsWith('http')) return imgPath
      return `/storage/${imgPath}`
    }

    const handleImageError = (event) => {
      event.target.src = 'https://via.placeholder.com/400x300?text=No+Image'
    }

    const truncateText = (text, length) => {
      if (!text) return ''
      return text.length > length ? text.substring(0, length) + '...' : text
    }

    // Lifecycle
    onMounted(() => {
      fetchAnggota()
      fetchBidangs()
    })

    return {
      // State
      anggotaStore,
      bidangStore,
      displayMode,
      showModal,
      modalMode,
      selectedAnggota,
      showDetailModal,
      detailAnggota,
      showDeleteModal,
      anggotaToDelete,
      filters,
      posisiOptions,
      
      // Computed
      hasActiveFilters,
      filteredAnggota,
      
      // Methods
      fetchAnggota,
      getCountByStatus,
      getBidangName,
      getBidang,
      resetFilters,
      openForm,
      closeModal,
      handleSaved,
      editAnggota,
      viewDetail,
      confirmDelete,
      handleDelete,
      getImageUrl,
      handleImageError,
      truncateText
    }
  }
}
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
</style>