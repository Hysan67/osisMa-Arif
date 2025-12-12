<!-- src/pages/Event.vue -->
<template>
    <div class="min-h-screen bg-transparent py-16">
        <div class="max-w-5xl mx-auto px-4 py-16">
            <router-link
                to="/"
                class="text-blue-600 hover:underline mb-8 inline-block font-light"
                data-aos="fade-left"
                data-aos-delay="500"
                >&larr; Kembali ke Beranda</router-link
            >

            <div class="text-center mb-20">
                <h1
                    class="text-5xl font-light text-blue-600"
                    data-aos="fade-up"
                    data-aos-delay="500"
                >
                    Artikel & Event
                </h1>
                <div
                    class="w-16 h-px bg-yellow-300 mx-auto mt-6"
                    data-aos="fade-right"
                    data-aos-delay="500"
                ></div>
                <p
                    class="text-gray-600 mt-8 max-w-2xl mx-auto"
                    data-aos="fade-left"
                    data-aos-delay="500"
                >
                    Simak artikel-artikel terbaru dari OSIS MA Ma’arif Udanawu.
                </p>
            </div>

            <div class="mb-8">
                <div class="relative max-w-md mx-auto">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        v-model="searchQuery"
                        type="search" 
                        placeholder="Cari artikel/event berdasarkan judul..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                    <button 
                        v-if="searchQuery"
                        @click="clearSearch"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                    >
                    </button>
                </div>
                <div v-if="searchQuery" class="mt-2 text-sm text-gray-600 text-center"> 
                    <span v-if="filteredEvents.length > 0">
                        Menampilkan {{ filteredEvents.length }} dari {{ allEvents.length }} artikel untuk pencarian: 
                        "<span class="font-semibold">{{ searchQuery }}</span>"
                    </span>
                    <span v-else>
                        Tidak ditemukan artikel dengan judul: 
                        "<span class="font-semibold">{{ searchQuery }}</span>"
                    </span>
                </div>
            </div>
            

            <div
                v-if="eventStore.loading"
                class="text-center py-12 text-gray-500"
            >
                Memuat data...
            </div>

            <div
                v-else-if="searchQuery && filteredEvents.length === 0"
                class="text-center py-12 text-gray-500"
            >
                Tidak ditemukan artikel/event dengan judul: "<span class="font-semibold">{{ searchQuery }}</span>"
            </div>

            <div
                v-else-if="!searchQuery && allEvents.length === 0"
                class="text-center py-12 text-gray-500"
            >
                Belum ada artikel yang dipublikasikan.
            </div>

            <div v-else class="space-y-16">
                <router-link
                    v-for="event in eventStore.events"
                    :key="event.id"
                    :to="`/event/${event.id}`"
                    class="block group"
                    data-aos="fade-up"
                    :data-aos-delay="event.id * 400"
                >
                    <div class="md:flex gap-10 items-start">
                        <div class="md:w-2/5 mb-6 md:mb-0">
                            <div
                                class="aspect-video bg-gray-200 rounded-xl overflow-hidden"
                            >
                                <img
                                    :src="
                                        event.image || '/placeholder-event.jpg'
                                    "
                                    :alt="event.title"
                                    class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105 group-hover:brightness-90"
                                />
                            </div>
                        </div>
                        <div class="md:w-3/5">
                            <h2
                                class="text-2xl font-light text-blue-600 group-hover:text-opacity-90 transition mb-2"
                                data-aos="fade-left"
                                data-aos-delay="500"
                            >
                                {{ event.title }}
                            </h2>
                            <p
                                class="text-gray-500 text-sm mb-3"
                                data-aos="fade-right"
                                data-aos-delay="500"
                            >
                                {{ event.date }}
                            </p>
                            <p
                                class="text-gray-700 leading-relaxed"
                                data-aos="fade-up"
                                data-aos-delay="500"
                            >
                                {{ event.desc }}
                            </p>
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

const searchQuery = ref('');

const allEvents = computed(() => eventStore.events || []);

const filteredEvents = computed(() => {
    if (!searchQuery.value.trim()) {
        return allEvents.value;
    }

    const query = searchQuery.value.toLowerCase();
    return allEvents.value.filter(event => 
        event.title.toLowerCase().includes(query) ||
        event.desc.toLowerCase().includes(query) // Opsional: cari juga di deskripsi
    );
});

// Method untuk membersihkan pencarian
function clearSearch() {
    searchQuery.value = '';
}

onMounted(() => {
    eventStore.fetchEvents();
});
</script>
