<!-- src/components/layout/Navbar.vue -->
<template>
   <nav class="bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg fixed top-0 w-full z-50 relative">
      <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center overflow-visible">
         <!-- Logo & Title -->
         <div class="flex items-center space-x-2">
            <!-- Logo Sekolah -->
            <img
               src="/logo-sekolah.png"
               alt="Logo OSIS"
               class="w-10 h-10 rounded-full"
            />
            <!-- Logo OSIS -->
            <img
               src="/logo-osis.png"
               alt="Logo MA Ma'arif Udanawu"
               class="w-10 h-10 rounded-full"
            />
            <span class="font-semibold text-lg">OSIS MA Ma'arif Udanawu</span>
         </div>

         <!-- Menu Desktop -->
         <ul class="hidden md:flex space-x-6 items-center">
            <li>
               <router-link
                  to="/"
                  class="hover:text-yellow-300 transition-colors duration-200 py-2"
                  :class="{ 'text-yellow-300': isActive('/') }"
               >
                  Beranda
               </router-link>
            </li>

            <!-- Dropdown: Bidang -->
            <li class="relative" ref="bidangDropdown">
               <button
                  @click="toggleDesktopDropdown('bidang')"
                  class="flex items-center hover:text-yellow-300 focus:outline-none transition-colors duration-200 py-2"
                  :class="{ 'text-yellow-300': desktopDropdownOpen.bidang }"
               >
                  Bidang
                  <svg
                     xmlns="http://www.w3.org/2000/svg"
                     class="ml-1 h-4 w-4 transition-transform duration-200"
                     :class="{ 'rotate-180': desktopDropdownOpen.bidang }"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                  >
                     <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                     />
                  </svg>
               </button>
               <ul
                  v-show="desktopDropdownOpen.bidang"
                  class="absolute left-0 mt-2 w-56 bg-blue-600 rounded-md shadow-lg z-20 border border-blue-400"
               >
                  <li>
                     <router-link
                        to="/bidang/inti"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Inti OSIS</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/1"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Bidang I – Kerohanian</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/2"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Bidang II – Kesiswaan</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/3"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Bidang III – Olahraga & Seni</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/4"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Bidang IV – Humas & Publikasi</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/5"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Bidang V – Sosial & Lingkungan</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/6"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Bidang VI – Kewirausahaan</router-link
                     >
                  </li>
               </ul>
            </li>

            <!-- Dropdown: Lainnya -->
            <li class="relative" ref="lainnyaDropdown">
               <button
                  @click="toggleDesktopDropdown('lainnya')"
                  class="flex items-center hover:text-yellow-300 focus:outline-none transition-colors duration-200 py-2"
                  :class="{ 'text-yellow-300': desktopDropdownOpen.lainnya }"
               >
                  Lainnya
                  <svg
                     xmlns="http://www.w3.org/2000/svg"
                     class="ml-1 h-4 w-4 transition-transform duration-200"
                     :class="{ 'rotate-180': desktopDropdownOpen.lainnya }"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                  >
                     <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                     />
                  </svg>
               </button>
               <ul
                  v-show="desktopDropdownOpen.lainnya"
                  class="absolute left-0 mt-2 w-56 bg-blue-600 rounded-md shadow-lg z-50 right-60 left-auto border border-blue-400"
               >
                  <li>
                     <router-link
                        to="/generasi"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Generasi Pengurus OSIS</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/event"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Event</router-link
                     >
                  </li>
                  <li>
                     <a
                        href="https://www.ma-almablitar.sch.id/"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        >Website Sekolah</a
                     >
                  </li>
               </ul>
            </li>
         </ul>

         <!-- Hamburger (Mobile) -->
         <div class="md:hidden">
            <button @click="toggleMenu" class="focus:outline-none">
               <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
               >
                  <path
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     stroke-width="2"
                     d="M4 6h16M4 12h16M4 18h16"
                  />
               </svg>
            </button>
         </div>
      </div>

      <!-- Mobile Menu Overlay -->
      <div
         v-if="isOpen"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
         @click="closeMenu"
      ></div>

      <!-- Mobile Menu Sidebar -->
      <div
         class="md:hidden fixed top-0 right-0 h-full w-80 bg-blue-600 z-50 transform transition-transform duration-300 ease-in-out"
         :class="isOpen ? 'translate-x-0' : 'translate-x-full'"
      >
         <div
            class="flex justify-between items-center p-4 border-b border-blue-500"
         >
            <span class="font-semibold text-lg">Menu</span>
            <button @click="closeMenu" class="focus:outline-none">
               <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
               >
                  <path
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     stroke-width="2"
                     d="M6 18L18 6M6 6l12 12"
                  />
               </svg>
            </button>
         </div>

         <ul class="px-4 py-4 space-y-3 overflow-y-auto h-full pb-20">
            <li>
               <router-link
                  to="/"
                  class="block py-3 px-4 rounded hover:bg-blue-700 transition-colors duration-200"
                  :class="{ 'bg-blue-700': isActive('/') }"
                  @click="closeMenu"
               >
                  Beranda
               </router-link>
            </li>

            <!-- Bidang (Mobile) -->
            <li>
               <button
                  @click="toggleSubmenu('bidang')"
                  class="flex justify-between items-center w-full text-left py-3 px-4 rounded hover:bg-blue-700 transition-colors duration-200"
               >
                  Bidang
                  <svg
                     xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4 transition-transform duration-200"
                     :class="{ 'rotate-180': submenuOpen.bidang }"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                  >
                     <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                     />
                  </svg>
               </button>
               <ul
                  v-show="submenuOpen.bidang"
                  class="mt-2 ml-4 space-y-2 bg-blue-700 rounded p-2"
               >
                  <li>
                     <router-link
                        to="/bidang/inti"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Inti OSIS</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/1"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Bidang I – Kerohanian</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/2"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Bidang II – Kesiswaan</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/3"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Bidang III – Olahraga & Seni</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/4"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Bidang IV – Humas & Publikasi</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/5"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Bidang V – Sosial & Lingkungan</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/bidang/6"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Bidang VI – Kewirausahaan</router-link
                     >
                  </li>
               </ul>
            </li>

            <!-- Lainnya (Mobile) -->
            <li>
               <button
                  @click="toggleSubmenu('lainnya')"
                  class="flex justify-between items-center w-full text-left py-3 px-4 rounded hover:bg-blue-700 transition-colors duration-200"
               >
                  Lainnya
                  <svg
                     xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4 transition-transform duration-200"
                     :class="{ 'rotate-180': submenuOpen.lainnya }"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                  >
                     <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                     />
                  </svg>
               </button>
               <ul
                  v-show="submenuOpen.lainnya"
                  class="mt-2 ml-4 space-y-2 bg-blue-700 rounded p-2"
               >
                  <li>
                     <router-link
                        to="/generasi"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Generasi Pengurus OSIS</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/event"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Event</router-link
                     >
                  </li>
                  <li>
                     <a
                        href="https://www.ma-almablitar.sch.id/"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        >Website Sekolah</a
                     >
                  </li>
               </ul>
            </li>
         </ul>
      </div>
   </nav>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const isOpen = ref(false);
const submenuOpen = reactive({
   bidang: false,
   lainnya: false,
});

const desktopDropdownOpen = reactive({
   bidang: false,
   lainnya: false,
});

const bidangDropdown = ref(null);
const lainnyaDropdown = ref(null);

const toggleMenu = () => (isOpen.value = !isOpen.value);
const closeMenu = () => {
   isOpen.value = false;
   // Tutup semua submenu mobile saat menu ditutup
   submenuOpen.bidang = false;
   submenuOpen.lainnya = false;
};

const toggleSubmenu = (name) => {
   submenuOpen[name] = !submenuOpen[name];
};

const toggleDesktopDropdown = (name) => {
   // Tutup dropdown lainnya sebelum membuka yang baru
   Object.keys(desktopDropdownOpen).forEach((key) => {
      if (key !== name) {
         desktopDropdownOpen[key] = false;
      }
   });

   desktopDropdownOpen[name] = !desktopDropdownOpen[name];
};

const closeAllDropdowns = () => {
   Object.keys(desktopDropdownOpen).forEach((key) => {
      desktopDropdownOpen[key] = false;
   });
};

const isActive = (path) => route.path === path;

// Tutup dropdown desktop saat klik di luar
const handleClickOutside = (event) => {
   if (bidangDropdown.value && !bidangDropdown.value.contains(event.target)) {
      desktopDropdownOpen.bidang = false;
   }

   if (lainnyaDropdown.value && !lainnyaDropdown.value.contains(event.target)) {
      desktopDropdownOpen.lainnya = false;
   }
};

onMounted(() => {
   document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
   document.removeEventListener("click", handleClickOutside);
});
</script>
