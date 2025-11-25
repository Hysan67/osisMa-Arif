// src/store/useEventStore.js
import { defineStore } from 'pinia'

export const useEventStore = defineStore('event', {
  state: () => ({
    events: [],
    loading: false
  }),
  actions: {
    async fetchEvents() {
      this.loading = true
      try {
        // simulasi ambil data
        await new Promise(resolve => setTimeout(resolve, 500))
        this.events = [
          {
            id: 1,
            title: 'Peringatan Isra Mi’raj',
            date: '28 Oktober 2025',
            desc: 'Kegiatan keagamaan berupa ceramah dan lomba sholawat antar kelas.',
            theme: 'Meneladani Rasulullah SAW dalam Kehidupan Sehari-hari',
            story: 'Kegiatan dimulai dengan pembacaan ayat suci Al-Qur’an.\nKemudian dilanjutkan dengan ceramah keagamaan dan lomba sholawat antar kelas.',
            closingGreeting: 'Terima kasih atas partisipasi seluruh santri!'
          },
          {
            id: 2,
            title: 'Ma’arif Cup 2025',
            date: '15–17 November 2025',
            desc: 'Perlombaan olahraga antar sekolah se-Kabupaten Blitar.',
            theme: 'Sportivitas dan Persaudaraan',
            story: 'Turnamen diikuti oleh berbagai sekolah di Blitar.\nAcara berlangsung seru dan meriah.',
            closingGreeting: 'Sampai jumpa di Ma’arif Cup berikutnya!'
          },
          {
            id: 3,
            title: 'Bazar Amal OSIS',
            date: '5 Desember 2025',
            desc: 'Penjualan hasil karya siswa untuk donasi sosial.',
            theme: 'Berbagi dalam Kebersamaan',
            story: 'Bazar diadakan di halaman sekolah.\nHasil penjualan disalurkan untuk membantu panti asuhan.',
            closingGreeting: 'Semoga membawa keberkahan untuk semua.'
          }
        ]
      } catch (error) {
        console.error('Gagal memuat event:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchEventById(id) {
      // kalau belum ada event di state, ambil dulu
      if (this.events.length === 0) {
        await this.fetchEvents()
      }

      // cari event berdasarkan id
      const found = this.events.find(e => e.id === Number(id))
      return found || null
    }
  }
})
