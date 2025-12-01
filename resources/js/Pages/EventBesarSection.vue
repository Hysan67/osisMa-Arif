<template>
  <div class="bg-transparant py-20">
    <div class="max-w-6xl mx-auto px-4" data-aos="fade-up" data-aos-delay="500">
      <h2 class="text-4xl font-light text-center text-blue-600 mb-16">Event Besar Kami</h2>

      <div class="space-y-20">
        <div
          v-for="(event, index) in events"
          :key="event.id"
          :class="['md:flex items-center gap-8', index % 2 !== 0 ? 'flex-row-reverse' : '']"
          :data-aos="index % 2 === 0 ? 'fade-right' : 'fade-left'"
          data-aos-delay="400"
        >
          <div class="md:w-1/2 mb-6 md:mb-0">
            <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden">
              <img :src="event.image" :alt="event.title" class="w-full h-full object-cover bg-gradient-to-t from-black/50 to-transparent"/>
            </div>
          </div>
          <div class="md:w-1/2 text-center md:text-left">
            <h3 class="text-2xl font-light text-blue-600 mb-4">{{ event.title }}</h3>
            <p class="text-gray-700">{{ event.desc }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const events = [
  {
    id: 1,
    title: "MA’ARIF CUP",
    desc: "Perlombaan antar sekolah tingkat Kabupaten Blitar yang mencakup cabang olahraga seperti futsal, voli, dan bulutangkis.",
    image: "/images/event-1.jpg"
  },
  {
    id: 2,
    title: "MA’ARIF COMPETITION",
    desc: "Kompetisi akademik tingkat MTs/SMP dan MA/SMA/SMK se-Jawa Timur, mencakup lomba MTQ, Pidato Bahasa Arab, dan Cerdas Cermat Keagamaan.",
    image: "/images/event-2.jpg"
  }
]
</script>
