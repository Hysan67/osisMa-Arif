<template>
  <div class="min-h-screen flex bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 h-screen overflow-y-auto bg-[#1E40AF] text-white flex flex-col fixed z-50">
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

    <!-- KONTEN ADMIN -->
    <main class="flex-1 ml-64 p-6">
      <router-view />
    </main>
  </div>
</template>
