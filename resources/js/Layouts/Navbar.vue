<!-- resources/js/Layouts/Navbar.vue -->
<template>
    <nav
        class="bg-gradient-to-r from-blue-600 to-blue-400 text-white fixed top-0 left-0 w-full z-50 shadow transition-shadow duration-300"
        :class="{ 'shadow-lg': isScrolled }"
    >
        <div
            class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center overflow-visible"
        >
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
                    src="/logo-osis.svg"
                    alt="Logo MA Ma'arif Udanawu"
                    class="w-10 h-10 rounded-full"
                />
                <span class="font-semibold text-lg"
                    >OSIS MA Ma'arif Udanawu</span
                >
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

            <!-- Link: Struktur OSIS -->
            <li>
               <router-link
                  to="/struktur-osis"
                  class="hover:text-yellow-300 transition-colors duration-200 py-2 block"
                  :class="{ 'text-yellow-300': isActive('/struktur-osis') }"
                  @click="closeAllDropdowns"
               >
                  Struktur OSIS
               </router-link>
            </li>

            <!-- Dropdown: Lainnya -->
            <li class="relative" ref="lainnyaDropdown">
               <button
                  @click="toggleDesktopDropdown('lainnya')"
                  class="flex items-center hover:text-yellow-300 focus:outline-none transition-colors duration-200 py-2"
                  :class="{ 'text-yellow-300': desktopDropdownOpen.lainnya || isActive('/form-aspirasi-siswa') || isActive('/pendaftaran-osis') || isActive('/event') }"
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
                  class="absolute mt-2 w-56 bg-blue-600 rounded-md shadow-lg z-50 right-0 left-auto border border-blue-400 translate-x-14"
               >
                  <li>
                     <router-link
                        to="/form-aspirasi-siswa"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Aspirasi Siswa</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/pendaftaran-osis"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeMenu"
                        >Daftar Osis</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/event"
                        class="block px-4 py-2 hover:bg-blue-700 transition-colors duration-200"
                        @click="closeAllDropdowns"
                        >Event & Artikel</router-link
                     >
                  </li>
                  <li>
                     <a
                        href="https://www.ma-almablitar.sch.id/"
                        class="block py-2 px-4 rounded hover:bg-blue-700 transition-colors duration-200"
                        target="_blank" rel="noopener noreferrer"
                        >Website Sekolah</a
                     >
                  </li>
               </ul>
            </li>
            <ul>
                 <router-link
                     to="/Login"
                     class="hover:text-yellow-300 transition-colors duration-200 py-2"
                     :class="{ 'text-yellow-300': isActive('/login') }"
                 >
                     Login
                 </router-link>
             </ul>
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

            <!-- Link Struktur OSIS (Mobile) -->
            <li>
               <router-link
                  to="/struktur-osis"
                  class="block py-3 px-4 rounded hover:bg-blue-700 transition-colors duration-200"
                  @click="closeMenu"
                  >
                  Struktur OSIS
               </router-link>
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
                        to="/event"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Event & Artikel</router-link
                     >
                  </li>
                  <li>
                     <a
                        href="https://www.ma-almablitar.sch.id/"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        target="_blank" rel="noopener noreferrer"
                        >Website Sekolah</a
                     >
                  </li>
                  <li>
                     <router-link
                        to="/form-aspirasi-siswa"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Aspirasi Siswa</router-link
                     >
                  </li>
                  <li>
                     <router-link
                        to="/pendaftaran-osis"
                        class="block py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-200"
                        @click="closeMenu"
                        >Daftar Osis</router-link
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
// Hanya menyimpan state submenu untuk 'lainnya'
const submenuOpen = reactive({
   lainnya: false,
});

// Hanya menyimpan state dropdown untuk 'lainnya'
const desktopDropdownOpen = reactive({
   lainnya: false,
});

// Referensi untuk dropdown 'lainnya' saja
const lainnyaDropdown = ref(null); // Ref 'strukurDropdown' dihapus

const toggleMenu = () => (isOpen.value = !isOpen.value);
const closeMenu = () => {
   isOpen.value = false;
   submenuOpen.lainnya = false; // Tutup submenu mobile 'lainnya'
};

// Toggle submenu mobile hanya untuk 'lainnya'
const toggleSubmenu = (name) => {
   if (name === 'lainnya') {
       submenuOpen[name] = !submenuOpen[name];
   }
};

// Toggle dropdown desktop hanya untuk 'lainnya'
const toggleDesktopDropdown = (name) => {
   if (name === 'lainnya') {
       desktopDropdownOpen[name] = !desktopDropdownOpen[name];
   }
};

// Tutup semua dropdown desktop (hanya 'lainnya' yang ada sekarang)
const closeAllDropdowns = () => {
   desktopDropdownOpen.lainnya = false;
};

const isActive = (path) => route.path === path;

// Fungsi untuk menangani klik di luar elemen dropdown
const handleClickOutside = (event) => {
   // Cek apakah yang diklik bukan dropdown 'lainnya' atau turunannya
   if (lainnyaDropdown.value && !lainnyaDropdown.value.contains(event.target)) {
      desktopDropdownOpen.lainnya = false; // Tutup dropdown 'lainnya'
   }
};

const isScrolled = ref(false);

const handleScroll = () => {
  isScrolled.value = window.scrollY > 10; // Tambahkan shadow saat scroll
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

// Event listener untuk klik di luar dropdown
onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>