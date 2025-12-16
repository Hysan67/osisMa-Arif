<template>
    <div class="min-h-screen bg-transparent py-16">
        <div class="max-w-5xl mx-auto px-4 py-16">
            <router-link
                to="/"
                class="flex items-center w-40 text-blue-600 hover:text-blue-800 mb-4 px-4 py-2 rounded-lg border border-blue-600 hover:bg-blue-50 transition"
                data-aos="fade-left"
                >&larr; Kembali ke Beranda</router-link
            >

            <div class="text-center mb-20">
                <h1
                    class="text-5xl font-light text-blue-600"
                    data-aos="fade-up"
                >
                    Artikel & Event
                </h1>
                <div
                    class="w-16 h-px bg-yellow-300 mx-auto mt-6"
                    data-aos="fade-right"
                ></div>
                <p
                    class="text-gray-600 mt-8 max-w-2xl mx-auto"
                    data-aos="fade-left"
                >
                    Simak artikel-artikel terbaru dari OSIS MA Ma'arif Udanawu.
                </p>
            </div>

            <!-- Filter Controls -->
            <div class="mb-8 flex flex-col md:flex-row gap-4 justify-between items-center">
                <!-- Tipe Filter -->
                <div class="w-full md:w-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Tipe</label>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="type in availableTypes"
                            :key="type.value"
                            @click="toggleType(type.value)"
                            :class="[
                                selectedType === type.value 
                                    ? 'bg-blue-600 text-white border-blue-600' 
                                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                                'px-4 py-2 rounded-lg border transition-all duration-200'
                            ]"
                        >
                            {{ type.label }}
                        </button>
                    </div>
                </div>

                <!-- Search Box -->
                <div class="w-full md:w-96">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Artikel/Event</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            v-model="searchQuery"
                            type="search" 
                            placeholder="Cari berdasarkan judul..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <button 
                            v-if="searchQuery"
                            @click="clearSearch"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Active Filters Display -->
            <div v-if="hasActiveFilters" class="mb-6 flex flex-wrap gap-2 items-center">
                <span class="text-sm text-gray-600">Filter aktif:</span>
                
                <!-- Selected Type Filter -->
                <span 
                    v-if="selectedType" 
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800"
                >
                    Tipe: {{ getTypeLabel(selectedType) }}
                    <button @click="clearType" class="ml-1 text-blue-600 hover:text-blue-800">
                        &times;
                    </button>
                </span>
                
                <!-- Search Filter -->
                <span 
                    v-if="searchQuery" 
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800"
                >
                    Pencarian: "{{ searchQuery }}"
                    <button @click="clearSearch" class="ml-1 text-green-600 hover:text-green-800">
                        &times;
                    </button>
                </span>
                
                <button 
                    @click="resetFilters"
                    class="text-sm text-red-600 hover:text-red-800 ml-2"
                >
                    Reset semua filter
                </button>
            </div>

            <!-- Results Summary -->
            <div class="mb-6 text-sm text-gray-600">
                <span v-if="filteredEvents.length > 0">
                    Menampilkan {{ filteredEvents.length }} dari {{ allEvents.length }} artikel
                    <span v-if="selectedType">(Tipe: {{ getTypeLabel(selectedType) }})</span>
                    <span v-if="searchQuery"> untuk pencarian: "<span class="font-semibold">{{ searchQuery }}</span>"</span>
                </span>
                <span v-else-if="!eventStore.loading">
                    Tidak ditemukan artikel
                    <span v-if="selectedType"> dengan tipe: {{ getTypeLabel(selectedType) }}</span>
                    <span v-if="searchQuery"> untuk pencarian: "<span class="font-semibold">{{ searchQuery }}</span>"</span>
                </span>
            </div>

            <!-- Loading State -->
            <div
                v-if="eventStore.loading"
                class="text-center py-12 text-gray-500"
            >
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-600 mb-2"></div>
                <p>Memuat data artikel...</p>
            </div>

            <!-- No Results State -->
            <div
                v-else-if="!eventStore.loading && filteredEvents.length === 0"
                class="text-center py-12 bg-gray-50 rounded-lg"
            >
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ditemukan artikel</h3>
                <p class="text-gray-600">Coba ubah filter atau kata pencarian Anda.</p>
                <button 
                    @click="resetFilters"
                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
                >
                    Reset Filter
                </button>
            </div>

            <!-- Events List -->
            <div v-else class="space-y-12">
                <router-link
                    v-for="event in filteredEvents"
                    :key="event.id"
                    :to="`/event/${event.id}`"
                    class="block group"
                    data-aos="fade-up"
                    :data-aos-delay="event.id * 200"
                >
                    <div class="md:flex gap-10 items-start bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="md:w-2/5 mb-6 md:mb-0">
                            <div class="relative aspect-video rounded-xl overflow-hidden">
                                <img
                                    :src="event.image || '/placeholder-event.jpg'"
                                    :alt="event.title"
                                    class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105 group-hover:brightness-90"
                                />
                                <!-- Type Badge -->
                                <div class="absolute top-3 left-3">
                                    <span 
                                        :class="[
                                            event.jenis_artikel === 'event' 
                                                ? 'bg-red-100 text-red-800 border-red-200'
                                                : 'bg-blue-100 text-blue-800 border-blue-200',
                                            'px-3 py-1 rounded-full text-xs font-medium border'
                                        ]"
                                    >
                                        {{ event.jenis_artikel === 'event' ? 'Event' : 'Artikel' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="md:w-3/5">
                            <div class="flex items-center justify-between mb-2">
                                <h2
                                    class="text-2xl font-semibold text-gray-900 group-hover:text-blue-600 transition-colors"
                                >
                                    {{ event.title }}
                                </h2>
                            </div>
                            <p
                                class="text-gray-500 text-sm mb-4"
                            >
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ event.date }}
                            </p>
                            <p
                                class="text-gray-700 leading-relaxed line-clamp-3"
                            >
                                {{ event.desc }}
                            </p>
                            <div class="mt-4">
                                <span class="inline-flex items-center text-blue-600 font-medium group-hover:text-blue-800 transition-colors">
                                    Baca selengkapnya
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useEventStore } from "../store/useEventStore";

const eventStore = useEventStore();

// Filter states
const searchQuery = ref('');
const selectedType = ref(''); // 'artikel', 'event', atau ''

// Available types
const availableTypes = [
    { value: '', label: 'Semua' },
    { value: 'artikel', label: 'Artikel' },
    { value: 'event', label: 'Event' }
];

// Computed properties
const allEvents = computed(() => eventStore.events || []);

const filteredEvents = computed(() => {
    let results = allEvents.value;

    // Filter by type
    if (selectedType.value) {
        results = results.filter(event => 
            event.jenis_artikel === selectedType.value
        );
    }

    // Filter by search query
    if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase();
        results = results.filter(event => 
            event.title.toLowerCase().includes(query) ||
            (event.desc && event.desc.toLowerCase().includes(query))
        );
    }

    return results;
});

const hasActiveFilters = computed(() => {
    return selectedType.value || searchQuery.value.trim();
});

// Methods
function toggleType(type) {
    selectedType.value = selectedType.value === type ? '' : type;
}

function clearType() {
    selectedType.value = '';
}

function clearSearch() {
    searchQuery.value = '';
}

function resetFilters() {
    selectedType.value = '';
    searchQuery.value = '';
}

function getTypeLabel(typeValue) {
    const type = availableTypes.find(t => t.value === typeValue);
    return type ? type.label : typeValue;
}

onMounted(() => {
    eventStore.fetchEvents();
});
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

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