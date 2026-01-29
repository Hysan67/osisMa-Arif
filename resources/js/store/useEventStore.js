// src/store/useEventStore.js
import { defineStore } from "pinia";
import axios from "axios";

export const useEventStore = defineStore("event", {
    state: () => ({
        events: [],
        loading: false,
        error: null,
        lastSearchQuery: "",
    }),
    actions: {
        async fetchEvents() {
            this.loading = true;
            this.error = null;
            try {
                // Gunakan axios untuk konsistensi
                const response = await axios.get("/artikels");
                
                // FORMAT BARU: response.data = {success: true, data: [...]}
                const responseData = response.data;
                let artikels = [];
                
                // Handle format response yang berbeda
                if (responseData && responseData.success && Array.isArray(responseData.data)) {
                    artikels = responseData.data; // Format baru
                } else if (Array.isArray(responseData)) {
                    artikels = responseData; // Format lama (backward compatibility)
                } else if (responseData && Array.isArray(responseData)) {
                    artikels = responseData; // Format alternatif
                } else {
                    console.warn("Format response tidak dikenali:", responseData);
                    artikels = [];
                }
                
                console.log('📊 Artikel diterima:', artikels.length, 'item');
                
                this.events = artikels.map((a) => ({
                    id: a.id,
                    title: a.judul,
                    desc: a.deskripsi,
                    image: a.img ? this.getImageUrl(a.img) : null,
                    date: a.created_at
                        ? new Date(a.created_at).toLocaleDateString("id-ID", {
                              day: "numeric",
                              month: "long",
                              year: "numeric",
                          })
                        : "Tanggal tidak tersedia",
                    jenis_artikel: a.jenis_artikel || "artikel", // Default value
                    expires_at: a.expires_at, // Tambahkan expires_at jika perlu
                    created_at: a.created_at,
                    updated_at: a.updated_at,
                }));
                
                console.log('✅ Events di-store:', this.events.length, 'item');
                
            } catch (error) {
                console.error("❌ Gagal memuat Artikel:", error);
                this.error = error.message || "Gagal mengambil data dari server";
                this.events = [];
            } finally {
                this.loading = false;
            }
        },

        // Helper function untuk mendapatkan URL gambar
        getImageUrl(imgPath) {
            if (!imgPath) return null;
            
            // Jika sudah URL lengkap
            if (imgPath.startsWith('http') || imgPath.startsWith('data:')) {
                return imgPath;
            }
            
            // Bersihkan path jika ada 'public/' di depan
            if (imgPath.startsWith('public/')) {
                imgPath = imgPath.replace('public/', '');
            }
            
            // Bersihkan slash di depan jika ada
            if (imgPath.startsWith('/')) {
                imgPath = imgPath.substring(1);
            }
            
            // Return URL yang benar
            return `/storage/${imgPath}`;
        },

        setLastSearchQuery(query) {
            this.lastSearchQuery = query;
        },

        async fetchEventById(id) {
            try {
                const response = await axios.get(`/api/artikels/${id}`);
                const artikel = response.data;
                
                // Handle format response
                let data = artikel;
                if (artikel && artikel.success && artikel.data) {
                    data = artikel.data;
                }
                
                return {
                    id: data.id,
                    title: data.judul,
                    desc: data.deskripsi,
                    image: data.img ? this.getImageUrl(data.img) : null,
                    date: data.created_at
                        ? new Date(data.created_at).toLocaleDateString("id-ID", {
                              day: "numeric",
                              month: "long",
                              year: "numeric",
                          })
                        : "",
                    jenis_artikel: data.jenis_artikel || "artikel",
                    expires_at: data.expires_at,
                    created_at: data.created_at,
                    updated_at: data.updated_at,
                };
            } catch (error) {
                console.error("❌ Gagal memuat detail artikel:", error);
                this.error = error.message || "Artikel tidak ditemukan";
                return null;
            }
        },

        // Method untuk filter events berdasarkan jenis
        getArticlesByType(type) {
            return this.events.filter(event => event.jenis_artikel === type);
        },

        // Method untuk mendapatkan artikel terbaru
        getRecentArticles(limit = 5) {
            return [...this.events]
                .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                .slice(0, limit);
        },

        // Method untuk mendapatkan event terbaru
        getRecentEvents(limit = 5) {
            return this.events
                .filter(event => event.jenis_artikel === "event")
                .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                .slice(0, limit);
        },

        // Method untuk mencari artikel
        searchArticles(keyword) {
            if (!keyword) return this.events;
            
            const query = keyword.toLowerCase();
            return this.events.filter(event => 
                event.title.toLowerCase().includes(query) ||
                event.desc.toLowerCase().includes(query) ||
                event.jenis_artikel.toLowerCase().includes(query)
            );
        }
    },
    
    // Getters untuk computed properties
    getters: {
        // Get semua artikel (jenis_artikel = "artikel")
        allArticles: (state) => state.events.filter(event => event.jenis_artikel === "artikel"),
        
        // Get semua event (jenis_artikel = "event")
        allEvents: (state) => state.events.filter(event => event.jenis_artikel === "event"),
        
        // Get semua pengumuman (jenis_artikel = "pengumuman")
        allAnnouncements: (state) => state.events.filter(event => event.jenis_artikel === "pengumuman"),
        
        // Get pengumuman aktif (belum expired)
        activeAnnouncements: (state) => {
            const now = new Date();
            return state.events.filter(event => 
                event.jenis_artikel === "pengumuman" &&
                (!event.expires_at || new Date(event.expires_at) > now)
            );
        },
        
        // Get total count per jenis
        counts: (state) => ({
            total: state.events.length,
            articles: state.events.filter(e => e.jenis_artikel === "artikel").length,
            events: state.events.filter(e => e.jenis_artikel === "event").length,
            announcements: state.events.filter(e => e.jenis_artikel === "pengumuman").length,
        }),
    },
});