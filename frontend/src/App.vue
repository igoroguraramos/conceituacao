<script setup lang="ts">
import { onMounted, ref } from 'vue'
import api from './services/api'

const message = ref('Carregando...')

onMounted(async () => {
  try {
    const response = await api.get('/hello')
    message.value = response.data.message
  } catch (error) {
    console.error('Erro ao comunicar com Laravel:', error)
    message.value = 'Erro na comunicação com a API'
  }
})
</script>

<template>
  <h1>{{ message }}</h1>
</template>

<style scoped></style>
