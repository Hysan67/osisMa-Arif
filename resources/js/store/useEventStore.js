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

                this.events = artikels.map((a) => ({
                    id: a.id,
                    title: a.judul,
                    desc: a.deskripsi,
                    image: a.img ? `/storage/${a.img}` : null,
                    date: a.created_at
                        ? new Date(a.created_at).toLocaleDateString("id-ID", {
                              day: "numeric",
                              month: "long",
                              year: "numeric",
                          })
                        : "Tanggal tidak tersedia",
                    // ✅ SERTAKAN jenis_artikel!
                    jenis_artikel: a.jenis_artikel, // ← INI YANG KURANG!
                }));
            } catch (error) {
                console.error("Gagal memuat Artikel:", error);
                this.events = [];
            } finally {
                this.loading = false;
            }
        },

        async fetchEventById(id) {
            try {
                const response = await fetch(`/api/artikels/${id}`);
                if (!response.ok) {
                    throw new Error("Artikel tidak ditemukan");
                }
                const artikel = await response.json();

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
                    // ✅ SERTAKAN juga di sini
                    jenis_artikel: artikel.jenis_artikel,
                };
            } catch (error) {
                console.error("Gagal memuat detail artikel:", error);
                return null;
            }
        },
    },
});
