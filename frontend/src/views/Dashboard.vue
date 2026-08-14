<script setup lang="ts">
import { ref, onMounted } from 'vue'

defineOptions({
  name: 'DashboardView'
})

interface User {
  id: number
  name: string
  email: string
}

const user = ref<User | null>(null)

onMounted(() => {
  const storedUser = localStorage.getItem('user')

  if (storedUser) {
    user.value = JSON.parse(storedUser)
  }
})
</script>

<template>
  <div>

    <div class="mb-4">
      <h2 class="fw-bold">
        Olá, {{ user?.name }}!
      </h2>

      <p class="text-muted">
        Bem-vindo ao seu dashboard.
      </p>
    </div>
  </div>
</template>