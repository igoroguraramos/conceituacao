import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useLoadingStore = defineStore('loading', () => {
  const activeRequests = ref(0)

  const isLoading = computed(() => activeRequests.value > 0)

  function start() {
    activeRequests.value++
  }

  function stop() {
    activeRequests.value = Math.max(0, activeRequests.value - 1)
  }

  return { isLoading, start, stop }
})
