// src/store/useEventStore.js
import { defineStore } from "pinia";

export const useEventStore = defineStore("event", {
    state: () => ({
        events: [],
        loading: false,
    }),
    actions: {
        async fetchEvents() {
            this.loading = true;
            try {
                const response = await fetch("/api/artikels");
                if (!response.ok) {
                    throw new Error("Gagal mengambil data dari server");
                }
                const artikels = await response.json();

                // Filter hanya yang jenis_artikel = 'event'
                // Lalu sesuaikan struktur field agar cocok dengan Event.vue
                this.events = artikels
                    .filter((a) => a.jenis_artikel === "event")
                    .map((a) => ({
                        id: a.id,
                        title: a.judul, // ← dari database
                        desc: a.deskripsi, // ← dari database
                        image: a.img ? `/storage/${a.img}` : null, // ← Laravel: stored di storage/app/public
                        date: a.created_at
                            ? new Date(a.created_at).toLocaleDateString(
                                  "id-ID",
                                  {
                                      day: "numeric",
                                      month: "long",
                                      year: "numeric",
                                  }
                              )
                            : "Tanggal tidak tersedia",
                    }));
            } catch (error) {
                console.error("Gagal memuat event:", error);
                this.events = [];
            } finally {
                this.loading = false;
            }
        },

        async fetchEventById(id) {
            try {
                const response = await fetch(`/api/artikels/${id}`);
                if (!response.ok) {
                    throw new Error("Event tidak ditemukan");
                }
                const artikel = await response.json();

                // Pastikan ini benar-benar event
                if (artikel.jenis_artikel !== "event") {
                    return null;
                }

                return {
                    id: artikel.id,
                    title: artikel.judul,
                    desc: artikel.deskripsi,
                    image: artikel.img ? `/storage/${artikel.img}` : null,
                    date: artikel.created_at
                        ? new Date(artikel.created_at).toLocaleDateString(
                              "id-ID",
                              {
                                  day: "numeric",
                                  month: "long",
                                  year: "numeric",
                              }
                          )
                        : "",
                    // Jika nanti tambah kolom seperti 'story', 'theme', dll di database,
                    // tambahkan di sini, contoh:
                    // story: artikel.story || '',
                    // theme: artikel.theme || '',
                };
            } catch (error) {
                console.error("Gagal memuat detail event:", error);
                return null;
            }
        },
    },
});
