<template>
    <div class="min-h-screen bg-transparent py-16">
        <div class="max-w-5xl mx-auto px-4 py-16">
            <router-link
                :to="{ path: '/event-artikel', query: { q: lastSearchQueryFromStore } }"
                class="flex items-center w-40 text-blue-600 hover:text-blue-800 mb-4 px-4 py-2 rounded-lg border border-blue-600 hover:bg-blue-50 transition"
                data-aos="fade-left"
                data-aos-delay="500"
                >&larr; Kembali ke Daftar Artikel</router-link
            >

            <div v-if="!event" class="text-center py-20 text-gray-500">
                Memuat kisah kegiatan...
            </div>

            <article v-else>
                <!-- Gambar Utama (Diperkecil) -->
                <div
                    class="flex justify-center mb-16"
                    data-aos="flip-left"
                    data-aos-delay="500"
                >
                    <div
                        class="w-full max-w-lg rounded-2xl overflow-hidden shadow-sm"
                    >
                        <div
                            class="aspect-video bg-gray-200 flex items-center justify-center"
                        >
                            <img
                                v-if="event.image"
                                :src="event.image"
                                :alt="event.title"
                                class="w-full h-full object-cover transition-all duration-500 hover:scale-105 hover:brightness-90"
                            />
                            <span v-else class="text-black text-xl font-light">
                                Dokumentasi: {{ event.title }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Konten -->
                <div class="prose prose-lg max-w-none">
                    <h1
                        class="text-5xl font-light text-blue-600 mb-4"
                        data-aos="fade-left"
                        data-aos-delay="500"
                    >
                        {{ event.title }}
                    </h1>
                    <p
                        class="text-gray-500 text-lg mb-10"
                        data-aos="fade-right"
                        data-aos-delay="500"
                    >
                        {{ event.date }}
                    </p>

                    <!-- Tema -->
                    <div v-if="event.theme" class="mb-12">
                        <div class="pl-6 border-l-2 border-yellow-300">
                            <p
                                class="italic text-xl text-gray-800 font-light"
                                data-aos="flip-right"
                                data-aos-delay="500"
                            >
                                “{{ event.theme }}”
                            </p>
                        </div>
                    </div>

                    <!-- Cerita - FIX: Menangani spasi dan baris baru -->
                    <div
                        class="space-y-6 text-gray-800 leading-relaxed"
                        data-aos="fade-up"
                        data-aos-delay="500"
                    >
                        <!-- Gunakan v-html jika ingin mempertahankan format -->
                        <div v-html="formattedStory"></div>
                        
                        <!-- ATAU gunakan p dengan white-space: pre-wrap -->
                        <!--
                        <div class="whitespace-pre-wrap">{{ event.story }}</div>
                        -->
                    </div>

                    <!-- Penutup -->
                    <div class="mt-16 pt-8 border-t border-gray-100">
                        <p
                            class="text-gray-700 mb-4"
                            data-aos="fade-left"
                            data-aos-delay="500"
                        >
                            Untuk teman-teman santri yang turut serta, kami
                            segenap panitia
                            <span class="font-medium text-blue-600"
                                >OSIS MA Ma'arif Udanawu</span
                            >
                            mengucapkan:
                        </p>
                        <p
                            class="text-3xl font-light text-blue-600"
                            data-aos="fade-left"
                            data-aos-delay="500"
                        >
                            {{ event.closingGreeting }}
                        </p>
                        <p
                            class="mt-6 text-gray-600"
                            data-aos="fade-right"
                            data-aos-delay="500"
                        >
                            Semoga kegiatan ini menjadi wasilah keberkahan,
                            kebersamaan, dan semangat untuk terus berkarya di
                            jalan Allah SWT.
                        </p>
                        <br />
                        <!-- Carousel Foto Event -->
                        <div
                            class="mt-10"
                            v-if="event.photos && event.photos.length"
                        >
                            <PhotoSlider :photos="event.photos" />
                        </div>
                        <br />
                        <!-- Tombol bagikan -->
                        <div
                            class="flex items-center gap-3 mb-10"
                            data-aos="zoom-in"
                            data-aos-delay="500"
                        >
                            <button
                                @click="shareEvent"
                                class="flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-600 transition-colors"
                            >
                                <i class="fas fa-share-alt"></i>
                                <span>Bagikan</span>
                            </button>

                            <button
                                @click="copyLink"
                                class="flex items-center gap-2 px-4 py-2 rounded-full border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors"
                            >
                                <i class="fas fa-link"></i>
                                <span>Salin Link</span>
                            </button>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import { useEventStore } from "../store/useEventStore";
import PhotoSlider from "@/Pages/PhotoSlider.vue";

const route = useRoute();
const store = useEventStore();
const event = ref(null);
const loading = ref(false);
const error = ref(null);

// Ambil query dari store
const lastSearchQueryFromStore = computed(() => store.lastSearchQuery);

// Format story untuk menangani spasi dan baris baru
const formattedStory = computed(() => {
    if (!event.value || !event.value.story) return '';
    
    // Jika story adalah array (sudah diproses)
    if (Array.isArray(event.value.story)) {
        return event.value.story
            .map(paragraph => {
                // Hapus spasi berlebih di awal dan akhir, pertahankan baris baru
                return `<p>${paragraph.trim().replace(/\n/g, '<br>')}</p>`;
            })
            .join('');
    }
    
    // Jika story adalah string
    let story = event.value.story;
    
    // Hapus spasi berlebih di awal dan akhir
    story = story.trim();
    
    // Ganti baris ganda menjadi paragraf
    const paragraphs = story.split(/\n\s*\n/);
    
    return paragraphs
        .map(paragraph => {
            // Hapus spasi berlebih di setiap paragraf
            const cleanParagraph = paragraph.trim();
            // Ganti baris tunggal dengan <br> di dalam paragraf
            return `<p>${cleanParagraph.replace(/\n/g, '<br>')}</p>`;
        })
        .join('');
});

onMounted(async () => {
    loading.value = true;
    error.value = null;
    
    try {
        const data = await store.fetchEventById(route.params.id);
        if (data) {
            event.value = {
                ...data,
                theme: data.theme || "",
                // Simpan story asli untuk diproses di computed property
                story: data.story || data.desc || "",
                closingGreeting: data.closingGreeting || "Barakallahu fiikum!",
            };
        } else {
            error.value = "Kegiatan tidak ditemukan";
        }
    } catch (err) {
        error.value = "Gagal memuat data kegiatan";
        console.error("Error loading event:", err);
    } finally {
        loading.value = false;
    }
});

function copyLink() {
    const link = window.location.href;
    navigator.clipboard.writeText(link)
        .then(() => {
            // Bisa tambahkan notifikasi yang lebih baik
            alert("Link artikel disalin ke clipboard!");
        })
        .catch(() => {
            alert("Gagal menyalin link");
        });
}

function shareEvent() {
    const link = window.location.href;
    if (navigator.share) {
        navigator.share({
            title: event.value?.title || "Kegiatan OSIS",
            text: "Yuk baca kisah kegiatan OSIS!",
            url: link,
        }).catch(() => {
            copyLink();
        });
    } else {
        copyLink();
    }
}
</script>

<style scoped>
/* Optional: Tambahkan style untuk formatting teks */
.prose :deep(p) {
    margin-bottom: 1.5rem;
    line-height: 1.8;
}

.prose :deep(br) {
    content: "";
    display: block;
    margin-bottom: 0.5em;
}
</style>