// src/composables/useAOSRefresh.js
import AOS from 'aos'
import { onMounted, onUpdated, nextTick } from 'vue'

export function useAOSRefresh(deps = []) {
  const refreshAOS = () => {
    nextTick(() => {
      AOS.refreshHard() // versi refresh paling aman
    })
  }

  onMounted(refreshAOS)
  onUpdated(refreshAOS)

  // Optional: refresh ulang tiap kali dep berubah (misal data async)
  if (deps.length) {
    deps.forEach(dep => {
      watch(dep, refreshAOS)
    })
  }
}
