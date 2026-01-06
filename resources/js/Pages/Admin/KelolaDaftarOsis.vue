<template>
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Pendaftaran OSIS</h1>
      <p class="text-gray-600">Kelola pendaftaran calon anggota OSIS</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Total Pendaftar</p>
            <p class="text-2xl font-bold text-gray-800">{{ stats.total || 0 }}</p>
          </div>
          <div class="p-3 bg-blue-100 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Menunggu</p>
            <p class="text-2xl font-bold text-yellow-600">{{ stats.pending || 0 }}</p>
          </div>
          <div class="p-3 bg-yellow-100 rounded-full">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Diterima</p>
            <p class="text-2xl font-bold text-green-600">{{ stats.approved || 0 }}</p>
          </div>
          <div class="p-3 bg-green-100 rounded-full">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Ditolak</p>
            <p class="text-2xl font-bold text-red-600">{{ stats.rejected || 0 }}</p>
          </div>
          <div class="p-3 bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters and Actions -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col md:flex-row gap-4">
          <!-- Search -->
          <div class="relative">
            <input v-model="search" @input="fetchData" type="text" placeholder="Cari nama, email, kelas..." 
                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>

          <!-- Status Filter -->
          <select v-model="statusFilter" @change="fetchData" 
                  class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="all">Semua Status</option>
            <option value="pending">Menunggu</option>
            <option value="approved">Diterima</option>
            <option value="rejected">Ditolak</option>
          </select>

          <!-- Sort -->
          <select v-model="sortBy" @change="fetchData" 
                  class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="created_at">Sortir: Terbaru</option>
            <option value="nama">Sortir: Nama A-Z</option>
            <option value="kelas">Sortir: Kelas</option>
          </select>
        </div>

        <div class="flex gap-2">
          <!-- Export Button -->
          <button @click="exportToCsv" 
                  class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export CSV
          </button>

          <!-- Refresh Button -->
          <button @click="fetchData" :disabled="loading"
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Refresh
          </button>
        </div>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-8">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
      <p class="mt-2 text-gray-600">Memuat data...</p>
    </div>

    <!-- Data Table -->
    <div v-else class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email/HP</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="item in data" :key="item.id" class="hover:bg-gray-50 transition-colors">
              <!-- Foto -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200">
                  <img v-if="item.foto_path" :src="`/storage/${item.foto_path}`" 
                       :alt="item.nama" class="w-full h-full object-cover">
                  <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                </div>
              </td>

              <!-- Nama -->
              <td class="px-6 py-4">
                <div>
                  <div class="text-sm font-medium text-gray-900">{{ item.nama }}</div>
                  <div class="text-xs text-gray-500">{{ item.asal_sekolah }}</div>
                </div>
              </td>

              <!-- Kelas -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ item.kelas }}</div>
                <div class="text-xs text-gray-500">{{ item.jenis_kelamin }}</div>
              </td>

              <!-- Kontak -->
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900 truncate max-w-[150px]">{{ item.email }}</div>
                <div class="text-xs text-gray-500">{{ item.no_hp }}</div>
              </td>

              <!-- Tanggal -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(item.created_at) }}
              </td>

              <!-- Status -->
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="[
                  'px-2 py-1 text-xs rounded-full font-medium',
                  item.status === 'approved' ? 'bg-green-100 text-green-800 border border-green-200' :
                  item.status === 'rejected' ? 'bg-red-100 text-red-800 border border-red-200' :
                  'bg-yellow-100 text-yellow-800 border border-yellow-200'
                ]">
                  {{ getStatusText(item.status) }}
                </span>
              </td>

              <!-- Actions -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-2">
                  <!-- View Details -->
                  <button @click="viewDetails(item)" title="Lihat Detail"
                          class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                  </button>

                  <!-- Edit Button -->
                  <button @click="editItem(item)" title="Edit Data"
                          class="p-1.5 text-purple-600 hover:text-purple-800 hover:bg-purple-50 rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                  </button>

                  <!-- Actions Dropdown -->
                  <div class="relative">
                    <button @click="toggleActions(item.id)" title="Pilihan Lain"
                            class="p-1.5 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-md transition-colors">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                      </svg>
                    </button>
                    
                    <!-- Action Menu -->
                    <div v-if="activeActions === item.id" 
                         class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg z-20 border border-gray-200 py-1">
                      <!-- Setujui (Approve) -->
                      <button @click="updateStatus(item.id, 'approved')" v-if="item.status !== 'approved'"
                              class="flex items-center w-full px-4 py-2 text-sm text-green-700 hover:bg-green-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Setujui
                      </button>
                      
                      <!-- Tolak (Reject) -->
                      <button @click="updateStatus(item.id, 'rejected')" v-if="item.status !== 'rejected'"
                              class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Tolak
                      </button>
                      
                      <!-- Kembalikan ke Pending -->
                      <button @click="updateStatus(item.id, 'pending')" v-if="item.status !== 'pending'"
                              class="flex items-center w-full px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h11M3 14h11m-7-4v8m-4 0h4a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Kembalikan ke Pending
                      </button>
                      
                      <!-- Divider -->
                      <div class="border-t border-gray-100 my-1"></div>
                      
                      <!-- Delete -->
                      <button @click="confirmDelete(item)"
                              class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                      </button>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Empty State -->
      <div v-if="!loading && data.length === 0" class="text-center py-8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pendaftaran</h3>
        <p class="mt-1 text-sm text-gray-500">Belum ada calon anggota yang mendaftar.</p>
      </div>

      <!-- Pagination -->
      <div v-if="data.length > 0" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700">
            Menampilkan <span class="font-medium">{{ data.length }}</span> dari <span class="font-medium">{{ total }}</span> pendaftar
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <!-- Modal Header -->
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">Detail Pendaftaran</h3>
            <button @click="showModal = false" class="text-gray-400 hover:text-gray-500 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- Modal Content -->
          <div v-if="selectedItem" class="space-y-6">
            <!-- Header Info -->
            <div class="flex items-start gap-4">
              <div class="w-24 h-24 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                <img v-if="selectedItem.foto_path" :src="`/storage/${selectedItem.foto_path}`" 
                     :alt="selectedItem.nama" class="w-full h-full object-cover">
                <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                  <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
              <div class="flex-1">
                <h4 class="text-xl font-bold text-gray-900">{{ selectedItem.nama }}</h4>
                <p class="text-gray-600">{{ selectedItem.kelas }} • {{ selectedItem.asal_sekolah }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ selectedItem.email }} • {{ selectedItem.no_hp }}</p>
                <div class="mt-2">
                  <span :class="[
                    'px-3 py-1 text-sm rounded-full font-medium',
                    selectedItem.status === 'approved' ? 'bg-green-100 text-green-800 border border-green-200' :
                    selectedItem.status === 'rejected' ? 'bg-red-100 text-red-800 border border-red-200' :
                    'bg-yellow-100 text-yellow-800 border border-yellow-200'
                  ]">
                    {{ getStatusText(selectedItem.status) }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Personal Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-gray-500 block mb-1">Tempat, Tanggal Lahir</label>
                <p class="text-gray-900">{{ selectedItem.tempat_lahir }}, {{ formatDate(selectedItem.tanggal_lahir) }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block mb-1">Jenis Kelamin</label>
                <p class="text-gray-900">{{ selectedItem.jenis_kelamin }}</p>
              </div>
              <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-500 block mb-1">Alamat</label>
                <p class="text-gray-900">{{ selectedItem.alamat }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block mb-1">Orang Tua/Wali</label>
                <p class="text-gray-900">{{ selectedItem.nama_ortu_wali }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block mb-1">Tanggal Persetujuan Ortu</label>
                <p class="text-gray-900">{{ formatDate(selectedItem.tanggal_ortu_wali) }}</p>
              </div>
            </div>

            <!-- Pengalaman & Prestasi -->
            <div v-if="selectedItem.pengalaman_prestasi">
              <label class="text-sm font-medium text-gray-500 block mb-1">Pengalaman & Prestasi</label>
              <p class="text-gray-900 whitespace-pre-line bg-gray-50 p-3 rounded-lg">{{ selectedItem.pengalaman_prestasi }}</p>
            </div>

            <!-- Tujuan & Harapan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-gray-500 block mb-1">Tujuan Masuk OSIS</label>
                <p class="text-gray-900 whitespace-pre-line bg-gray-50 p-3 rounded-lg">{{ selectedItem.tujuan }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block mb-1">Harapan Setelah Bergabung</label>
                <p class="text-gray-900 whitespace-pre-line bg-gray-50 p-3 rounded-lg">{{ selectedItem.harapan }}</p>
              </div>
            </div>

            <!-- Additional Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div v-if="selectedItem.penyakit_diderita">
                <label class="text-sm font-medium text-gray-500 block mb-1">Penyakit yang Diderita</label>
                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ selectedItem.penyakit_diderita }}</p>
              </div>
              <div v-if="selectedItem.rutinitas_menghambat">
                <label class="text-sm font-medium text-gray-500 block mb-1">Rutinitas yang Menghambat</label>
                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ selectedItem.rutinitas_menghambat }}</p>
              </div>
            </div>

            <!-- Timestamp -->
            <div class="pt-4 border-t border-gray-200">
              <p class="text-sm text-gray-500">
                Didaftarkan pada {{ formatDateTime(selectedItem.created_at) }}
                <span v-if="selectedItem.updated_at"> • Terakhir diperbarui {{ formatDateTime(selectedItem.updated_at) }}</span>
              </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4">
              <button @click="showModal = false"
                      class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Tutup
              </button>
              <button @click="editItem(selectedItem)"
                      class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
              </button>
              <button v-if="selectedItem.status === 'pending'" @click="updateStatus(selectedItem.id, 'approved')"
                      class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                </svg>
                Setujui
              </button>
              <button v-if="selectedItem.status === 'pending'" @click="updateStatus(selectedItem.id, 'rejected')"
                      class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Tolak
              </button>
              <button v-if="selectedItem.status !== 'pending'" @click="updateStatus(selectedItem.id, 'pending')"
                      class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h11M3 14h11m-7-4v8m-4 0h4a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Kembali ke Pending
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <!-- Edit Modal Header -->
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">Edit Pendaftaran</h3>
            <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-500 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- Edit Form -->
          <form @submit.prevent="saveEdit" class="space-y-4">
            <!-- Nama -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
              <input v-model="editForm.nama" required type="text"
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input v-model="editForm.email" required type="email"
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
            </div>

            <!-- Kelas -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
              <input v-model="editForm.kelas" required type="text"
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
            </div>

            <!-- Status -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
              <select v-model="editForm.status" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                <option value="pending">Menunggu</option>
                <option value="approved">Diterima</option>
                <option value="rejected">Ditolak</option>
              </select>
            </div>

            <!-- Notes -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
              <textarea v-model="editForm.notes" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition"></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4">
              <button type="button" @click="showEditModal = false"
                      class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Batal
              </button>
              <button type="submit" :disabled="saving"
                      class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center gap-2 transition-colors disabled:opacity-50">
                <svg v-if="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ saving ? 'Menyimpan...' : 'Simpan Perubahan' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <div class="text-center">
          <svg class="mx-auto h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Hapus Pendaftaran</h3>
          <p class="mt-2 text-sm text-gray-500">
            Apakah Anda yakin ingin menghapus pendaftaran <strong>{{ itemToDelete?.nama }}</strong>? 
            Tindakan ini tidak dapat dibatalkan.
          </p>
        </div>
        <div class="mt-6 flex justify-center gap-3">
          <button @click="showDeleteModal = false"
                  class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Batal
          </button>
          <button @click="deleteRegistration" 
                  class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
            Hapus
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const data = ref([])
const stats = ref({})
const loading = ref(false)
const saving = ref(false)
const search = ref('')
const statusFilter = ref('all')
const sortBy = ref('created_at')
const total = ref(0)
const showModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const selectedItem = ref(null)
const itemToDelete = ref(null)
const activeActions = ref(null)

// Edit form
const editForm = ref({
  id: '',
  nama: '',
  email: '',
  kelas: '',
  status: 'pending',
  notes: ''
})

// Get user from localStorage for admin_id
const user = JSON.parse(localStorage.getItem('user') || '{}')

// Fetch data
const fetchData = async () => {
  try {
    loading.value = true
    const params = {
      search: search.value,
      status: statusFilter.value !== 'all' ? statusFilter.value : undefined,
      sort_by: sortBy.value,
      sort_order: 'desc'
    }

    const [resData, resStats] = await Promise.all([
      axios.get('/pendaftaran-osis', { params }),
      axios.get('/pendaftaran-osis/stats')
    ])

    if (resData.data.success) {
      data.value = resData.data.data
      total.value = resData.data.total
    }

    if (resStats.data.success) {
      stats.value = resStats.data.data
    }
  } catch (error) {
    console.error('Error fetching data:', error)
    alert('Gagal memuat data pendaftaran')
  } finally {
    loading.value = false
  }
}

// Format date
const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}

// Format date time
const formatDateTime = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Get status text
const getStatusText = (status) => {
  const statusMap = {
    pending: 'Menunggu',
    approved: 'Diterima',
    rejected: 'Ditolak'
  }
  return statusMap[status] || status
}

// View details
const viewDetails = (item) => {
  selectedItem.value = item
  showModal.value = true
  activeActions.value = null
}

// Edit item
const editItem = (item) => {
  editForm.value = {
    id: item.id,
    nama: item.nama,
    email: item.email,
    kelas: item.kelas,
    status: item.status,
    notes: item.notes || ''
  }
  showEditModal.value = true
  showModal.value = false
}

// Save edit
const saveEdit = async () => {
  try {
    saving.value = true
    
    // First update status if changed
    if (selectedItem.value && selectedItem.value.status !== editForm.value.status) {
      await updateStatus(editForm.value.id, editForm.value.status)
    }
    
    // Then update other fields
    const response = await axios.put(`/pendaftaran-osis/${editForm.value.id}`, {
      ...editForm.value,
      admin_id: user.id || null
    })

    if (response.data.success) {
      alert('Data berhasil diperbarui')
      fetchData()
      showEditModal.value = false
      selectedItem.value = null
    }
  } catch (error) {
    console.error('Error updating:', error)
    alert('Gagal memperbarui data')
  } finally {
    saving.value = false
  }
}

// Toggle actions menu
const toggleActions = (id) => {
  activeActions.value = activeActions.value === id ? null : id
}

// Update status
const updateStatus = async (id, status) => {
  if (!confirm(`Apakah Anda yakin ingin mengubah status menjadi "${getStatusText(status)}"?`)) {
    return
  }

  try {
    const response = await axios.put(`/pendaftaran-osis/${id}/status`, {
      status,
      admin_id: user.id || null,
      notes: editForm.value.notes || ''
    })

    if (response.data.success) {
      alert('Status berhasil diperbarui')
      fetchData()
      
      // Update selected item if modal is open
      if (selectedItem.value && selectedItem.value.id === id) {
        selectedItem.value = response.data.data
      }
      
      activeActions.value = null
      showEditModal.value = false
    }
  } catch (error) {
    console.error('Error updating status:', error)
    alert('Gagal memperbarui status')
  }
}

// Confirm delete
const confirmDelete = (item) => {
  itemToDelete.value = item
  showDeleteModal.value = true
  activeActions.value = null
}

// Delete registration
const deleteRegistration = async () => {
  try {
    const response = await axios.delete(`/pendaftaran-osis/${itemToDelete.value.id}`)

    if (response.data.success) {
      alert('Pendaftaran berhasil dihapus')
      fetchData()
      showDeleteModal.value = false
      itemToDelete.value = null
    }
  } catch (error) {
    console.error('Error deleting:', error)
    alert('Gagal menghapus pendaftaran')
  }
}

// Export to CSV
const exportToCsv = async () => {
  try {
    const response = await axios.get('/pendaftaran-osis/export', {
      responseType: 'blob'
    })

    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', `pendaftaran_osis_${new Date().toISOString().slice(0, 10)}.csv`)
    document.body.appendChild(link)
    link.click()
    link.remove()
  } catch (error) {
    console.error('Error exporting:', error)
    alert('Gagal mengekspor data')
  }
}

// Close modal on outside click
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative') && activeActions.value) {
    activeActions.value = null
  }
}

// Mount
onMounted(() => {
  fetchData()
  document.addEventListener('click', handleClickOutside)
})
</script>