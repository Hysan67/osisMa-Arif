<template>
    <div
        class="relative max-w-4xl mx-auto"
        data-aos="flip-left"
        data-aos-delay="700"
    >
        <div
            v-if="props.images?.length"
            class="bg-gray-200 aspect-video rounded-xl flex items-center justify-center overflow-hidden"
        >
            <img
                :src="
                    props.images[currentIndex]?.image ||
                    '/images/placeholder.jpg'
                "
                :alt="props.images[currentIndex]?.title || 'Foto kegiatan'"
                class="w-full h-full object-cover"
                @error="onImageError"
            />
        </div>
        <div
            v-else
            class="bg-gray-200 aspect-video rounded-xl flex items-center justify-center"
        >
            <span class="text-gray-600">Tidak ada gambar</span>
        </div>

        <button
            v-if="props.images?.length > 1"
            @click="prevImage"
            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white p-2 rounded-full shadow-md"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
        </button>
        <button
            v-if="props.images?.length > 1"
            @click="nextImage"
            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white p-2 rounded-full shadow-md"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </button>

        <div
            v-if="props.images?.length > 1"
            class="flex justify-center mt-4 space-x-2"
        >
            <button
                v-for="(_, index) in props.images"
                :key="index"
                @click="goToImage(index)"
                class="w-3 h-3 rounded-full"
                :class="{
                    'bg-blue-600': index === currentIndex,
                    'bg-gray-400': index !== currentIndex,
                }"
            ></button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const props = defineProps({
    images: {
        type: Array,
        default: () => [],
    },
});

const currentIndex = ref(0);

const prevImage = () => {
    if (props.images?.length > 0) {
        currentIndex.value =
            (currentIndex.value - 1 + props.images.length) %
            props.images.length;
    }
};

const nextImage = () => {
    if (props.images?.length > 0) {
        currentIndex.value = (currentIndex.value + 1) % props.images.length;
    }
};

const goToImage = (index) => {
    currentIndex.value = index;
};

let interval;
onMounted(() => {
    if (props.images?.length > 1) {
        interval = setInterval(nextImage, 5000);
    }
});
onUnmounted(() => {
    if (interval) clearInterval(interval);
});
</script>
